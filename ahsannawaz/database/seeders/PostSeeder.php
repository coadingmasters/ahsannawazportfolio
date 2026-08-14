<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * The starting set of articles.
 *
 * Each one is written around a search phrase someone would actually type
 * when they are stuck, and they link to each other so the three read as one
 * body of work rather than three orphans. Slugs carry the keyword, since the
 * URL is one of the few things a person sees before they click.
 *
 * Bodies are HTML because the admin editor produces HTML; it is sanitised on
 * save, and this seeder only uses tags that survive that allowlist.
 */
class PostSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->posts() as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }

    private function posts(): array
    {
        return [
            [
                'slug' => 'deploy-laravel-hostinger-shared-hosting',
                'title' => 'Deploy Laravel on Hostinger Shared Hosting: Full Guide',
                'category' => 'laravel',
                'read_minutes' => 9,
                'published_at' => Carbon::now()->subDays(12),
                'excerpt' => 'Deploy Laravel on Hostinger shared hosting step by step: SSH keys, the right PHP version, public_html layout, migrations, and the three things that break it.',
                'body' => <<<'HTML'
<p>Shared hosting is where most client Laravel projects end up, and Hostinger is one of the cheapest places to put one. It also has three quirks that will break your first deploy: the PHP version the account defaults to, a <code>public_html</code> that expects a plain PHP site, and a CDN that keeps serving your old CSS for a week. This guide walks the whole deploy and fixes all three.</p>

<h2>What you need before you start</h2>
<ul>
<li>A Hostinger plan with SSH access (Premium and above)</li>
<li>Your Laravel project in a Git repository</li>
<li>A MySQL database created in hPanel</li>
</ul>

<h2>1. Set up SSH key access</h2>
<p>hPanel gives you an SSH host, port and password. Typing that password on every deploy gets old immediately, so add a key once:</p>
<pre><code>ssh-keygen -t ed25519 -f ~/.ssh/hostinger -C "deploy"
ssh-copy-id -i ~/.ssh/hostinger.pub -p 65002 u123456789@your-server-ip</code></pre>
<p>Then add a host alias to <code>~/.ssh/config</code> so you can type <code>ssh myhost</code> instead of the full command:</p>
<pre><code>Host myhost
    HostName 145.79.0.0
    User u123456789
    Port 65002
    IdentityFile ~/.ssh/hostinger</code></pre>
<p>Once the key works you can change the account password without breaking deployment, which is worth doing since that password arrived in an email.</p>

<h2>2. Pick the right PHP version — this is where most deploys die</h2>
<p>Laravel 11 and 12 pull in Symfony packages that require a recent PHP. Hostinger accounts often default the CLI to an older build, so <code>composer install</code> fails with a wall of messages like:</p>
<pre><code>symfony/console v8.0.0 requires php >=8.4 -> your php version (8.3.30) does not satisfy that requirement.</code></pre>
<p>Changing the PHP version in hPanel only changes what the <em>web</em> requests use. The SSH shell keeps its own default. Check what you actually have:</p>
<pre><code>php -v
ls -d /opt/alt/php8*</code></pre>
<p>If a newer build is installed, call it directly for Composer and Artisan:</p>
<pre><code>/opt/alt/php84/usr/bin/php /usr/local/bin/composer install --no-dev -o
/opt/alt/php84/usr/bin/php artisan migrate --force</code></pre>
<p>To make the web side match, add a handler line at the top of your <code>.htaccess</code>:</p>
<pre><code>AddHandler application/x-httpd-alt-php84 .php</code></pre>
<p>Put that in the file rather than only in hPanel, otherwise a future account change silently reverts it and the site 500s.</p>

<h2>3. Decide where the app lives</h2>
<p>Hostinger serves <code>~/domains/yourdomain.com/public_html</code> as the web root. Laravel expects only its <code>public</code> directory to be reachable. You have two options.</p>

<h3>The secure layout</h3>
<p>Put the application one level above the web root and copy only the contents of <code>public/</code> into <code>public_html</code>, then edit the two require paths in <code>index.php</code>. Nothing outside <code>public/</code> is reachable, which is how Laravel is designed to run.</p>

<h3>The everything-inside layout</h3>
<p>Put the whole application inside <code>public_html</code> and route requests into <code>public/</code> with a rewrite. Easier to picture, but your <code>.env</code> now sits under the web root, so it depends entirely on <code>.htaccess</code> holding:</p>
<pre><code>RewriteEngine On
RewriteRule ^(\.env|artisan|composer\.(json|lock))$ - [F,L]
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ public/$1 [L]</code></pre>
<p>If you take this route, drop a <code>.htaccess</code> containing <code>Require all denied</code> inside <code>app/</code>, <code>config/</code>, <code>vendor/</code> and <code>storage/</code> as well. Then actually test it — request <code>/.env</code> in a browser and confirm you get a 403, not a download.</p>

<h2>4. Environment and database</h2>
<p>Create the database in hPanel first. Hostinger prefixes both the database and the user with your account ID, so a database you named <code>blog</code> is really <code>u123456789_blog</code>. Using the name you typed will fail with an access-denied error that looks like a password problem but is not.</p>
<pre><code>APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
DB_DATABASE=u123456789_blog
DB_USERNAME=u123456789_blog
DB_PASSWORD="your-password"</code></pre>
<p>Keep <code>.env</code> out of your deploy sync so a push never overwrites live credentials, and generate the key on the server once with <code>php artisan key:generate</code>.</p>

<h2>5. Deploy, migrate, cache</h2>
<p>Whether you rsync from your machine or <code>git pull</code> on the server, the remote half is the same every time:</p>
<pre><code>composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache</code></pre>
<p>Exclude <code>vendor/</code>, <code>node_modules/</code>, <code>.env</code> and your uploads directory from whatever copies files up. Deleting a client's uploaded images because rsync ran with <code>--delete</code> is a bad afternoon.</p>

<h2>6. The three things that still bite you</h2>

<h3>Asset builds fail on the server</h3>
<p>Vite's newer bundler needs to spawn threads, and shared hosting process limits stop it, so <code>npm run build</code> panics. Build locally and upload the output, or commit the built assets.</p>

<h3>storage:link does nothing</h3>
<p>Hostinger disables PHP's <code>symlink()</code>, so <code>artisan storage:link</code> cannot create the link uploads are served through. There is a clean way around it — I wrote that up separately in <a href="/blog/laravel-storage-link-symlink-disabled-shared-hosting">fixing Laravel file uploads when symlink() is disabled</a>.</p>

<h3>Your CSS changes do not appear</h3>
<p>Hostinger's CDN caches static files for seven days. You deploy, you reload, and you still see the old stylesheet — so you assume the deploy failed and deploy again. It did not fail; the file is simply cached. The fix is asset versioning, covered in <a href="/blog/laravel-asset-cache-busting-cdn">why your site serves old CSS after deploying</a>.</p>

<h2>A deploy checklist worth keeping</h2>
<ul>
<li>SSH key added, password login no longer needed</li>
<li>PHP version correct for both CLI and web</li>
<li><code>.env</code> present, excluded from sync, <code>APP_DEBUG=false</code></li>
<li><code>/.env</code> returns 403 in a browser</li>
<li>Migrations run, caches rebuilt</li>
<li>Uploads directory excluded from deletion</li>
<li>Assets versioned so the CDN cannot serve stale files</li>
</ul>
<p>Get those seven right and Laravel runs on shared hosting perfectly well. Most of the horror stories come from one of them being missed, not from the platform.</p>
HTML,
            ],

            [
                'slug' => 'laravel-storage-link-symlink-disabled-shared-hosting',
                'title' => 'Fix Laravel storage:link When symlink() Is Disabled',
                'category' => 'laravel',
                'read_minutes' => 6,
                'published_at' => Carbon::now()->subDays(7),
                'excerpt' => 'Shared hosts disable PHP symlink(), so artisan storage:link fails and uploads 404. Here is why, and the config change that fixes it without a symlink.',
                'body' => <<<'HTML'
<p>You upload an image through your admin panel, the record saves, and the file is genuinely on disk — but the page shows a broken image. You run the usual fix and get nothing useful back:</p>
<pre><code>php artisan storage:link

   ERROR  symlink(): Cannot create symlink, error code(1)</code></pre>
<p>This is not a permissions problem and re-running it will not help. Most shared hosts disable PHP's <code>symlink()</code> function outright.</p>

<h2>Why the link exists at all</h2>
<p>Laravel keeps uploads in <code>storage/app/public</code>, which sits outside the web root on purpose — nothing there is reachable until you say so. <code>storage:link</code> creates a symlink at <code>public/storage</code> pointing back to it, so <code>asset('storage/photo.jpg')</code> resolves.</p>
<p>Confirm the function is blocked before assuming anything else:</p>
<pre><code>php -r "var_dump(function_exists('symlink'));"
php -i | grep disable_functions</code></pre>
<p>If <code>symlink</code> appears in <code>disable_functions</code>, no amount of chmod will help.</p>

<h2>The fix: point the disk at a directory that is already public</h2>
<p>Instead of linking into the web root, tell the <code>public</code> disk to write there in the first place. Make the root configurable in <code>config/filesystems.php</code>:</p>
<pre><code>'public' =&gt; [
    'driver' =&gt; 'local',
    'root' =&gt; env('FILESYSTEM_PUBLIC_ROOT')
        ? base_path(env('FILESYSTEM_PUBLIC_ROOT'))
        : storage_path('app/public'),
    'url' =&gt; env('APP_URL').'/storage',
    'visibility' =&gt; 'public',
],</code></pre>
<p>Then in production only:</p>
<pre><code>FILESYSTEM_PUBLIC_ROOT=public/storage</code></pre>
<p>Locally the variable is unset, so everything behaves normally with the usual symlink. On the server files land in <code>public/storage</code>, which the web server already serves, and <code>asset('storage/...')</code> resolves to exactly the same URL it always did. No application code changes.</p>

<h2>Create the directory and check it</h2>
<pre><code>mkdir -p public/storage
chmod -R 775 public/storage</code></pre>
<p>Then prove it end to end rather than trusting it:</p>
<pre><code>php artisan tinker
&gt;&gt;&gt; Storage::disk('public')-&gt;put('test.txt', 'ok');
&gt;&gt;&gt; Storage::disk('public')-&gt;path('test.txt');</code></pre>
<p>Request <code>/storage/test.txt</code> in a browser. A 200 means uploads work. Delete the file afterwards.</p>

<h2>The trap: blocking storage too aggressively</h2>
<p>If your app lives inside <code>public_html</code> you have probably denied web access to <code>storage/</code> — sensible, since that is where logs and sessions live. But the public URL for uploads is also <code>/storage/...</code>, so a blanket rule returns 403 for every image.</p>
<p>Deny the internals individually rather than the whole directory. Put a <code>.htaccess</code> containing <code>Require all denied</code> inside <code>storage/logs</code>, <code>storage/framework</code> and <code>storage/app</code>, and leave <code>storage/</code> itself alone. Then confirm both halves:</p>
<ul>
<li><code>/storage/test.txt</code> → 200</li>
<li><code>/storage/logs/laravel.log</code> → 403</li>
</ul>

<h2>Things to know before you ship this</h2>
<ul>
<li><strong>Exclude uploads from deployment.</strong> They now live under <code>public/</code>, so a sync with <code>--delete</code> will happily remove every client image. Exclude <code>public/storage</code> explicitly.</li>
<li><strong>Back them up.</strong> Uploads are outside version control, so nothing else is protecting them.</li>
<li><strong>Local behaviour is unchanged.</strong> The variable is production-only, so nobody on the team has to think about it.</li>
</ul>

<p>This is one of a handful of things that catch people out on cheap hosting. The rest are collected in <a href="/blog/deploy-laravel-hostinger-shared-hosting">my full guide to deploying Laravel on Hostinger shared hosting</a>.</p>
HTML,
            ],

            [
                'slug' => 'laravel-asset-cache-busting-cdn',
                'title' => 'Site Shows Old CSS After Deploy? Fix Asset Caching',
                'category' => 'php',
                'read_minutes' => 6,
                'published_at' => Carbon::now()->subDays(3),
                'excerpt' => 'Deployed, but visitors still get the old stylesheet? It is almost always CDN caching. How to version assets in Laravel so a deploy is visible immediately.',
                'body' => <<<'HTML'
<p>You change a stylesheet, deploy, reload, and nothing happens. You SSH in and the file on the server is definitely the new one. You deploy again. Still nothing. Then you open the site on your phone and see the new design straight away.</p>
<p>Nothing is broken. Your browser and your host's CDN are both holding a copy of the old file, and neither has any reason to ask for a new one.</p>

<h2>Confirm it before you change anything</h2>
<p>Check what the server actually sends:</p>
<pre><code>curl -sSI https://yoursite.com/css/app.css | grep -i "cache-control\|age"</code></pre>
<p>A response like this is the whole story:</p>
<pre><code>cache-control: public, max-age=604800
x-cache-status: HIT</code></pre>
<p><code>604800</code> seconds is seven days. Until that expires, the CDN answers from its own copy and your server is never asked. Compare the two directly:</p>
<pre><code>curl -sS https://yoursite.com/css/app.css | head -5
curl -sS "https://yoursite.com/css/app.css?anything" | head -5</code></pre>
<p>If the second shows your changes and the first does not, it is caching, not deployment.</p>

<h2>The fix: change the URL whenever the file changes</h2>
<p>Caching aggressively is correct — you just need a new URL when the content changes. The simplest reliable stamp is the file's modification time.</p>
<p>Add a small helper:</p>
<pre><code>namespace App\Support;

class Asset
{
    public static function url(string $path): string
    {
        $file = public_path($path);

        return asset($path).(is_file($file) ? '?v='.filemtime($file) : '');
    }
}</code></pre>
<p>And a Blade directive so templates stay readable:</p>
<pre><code>Blade::directive('css', function ($expression) {
    return "&lt;?php echo '&lt;link rel=\"stylesheet\" href=\"'
        . e(\App\Support\Asset::url({$expression})) . '\"&gt;'; ?&gt;";
});</code></pre>
<p>Use it in place of the usual link tag:</p>
<pre><code>@css('css/app.css')</code></pre>
<p>Which renders as <code>/css/app.css?v=1786621606</code>. Edit the file and the number changes, so the CDN treats it as a new object and fetches it. Nothing else changes and no cache needs purging.</p>

<h3>Do the same for scripts</h3>
<p>It is easy to version stylesheets, see the problem disappear, and forget JavaScript entirely — until a script change fails to appear a week later. Add the matching <code>@js()</code> directive at the same time.</p>

<h2>Now cache harder, not less</h2>
<p>With versioned URLs you can safely tell browsers to keep assets for a year, because a changed file arrives under a different URL:</p>
<pre><code>&lt;IfModule mod_headers.c&gt;
    &lt;FilesMatch "\.(css|js|woff2|webp|png|jpe?g|svg)$"&gt;
        Header set Cache-Control "public, max-age=31536000, immutable"
    &lt;/FilesMatch&gt;
    &lt;FilesMatch "\.(html|php)$"&gt;
        Header set Cache-Control "no-cache, must-revalidate"
    &lt;/FilesMatch&gt;
&lt;/IfModule&gt;</code></pre>
<p>The second block matters as much as the first. HTML must never be cached that way, or your deploy becomes invisible again — this time for a year.</p>

<h2>What about fonts and images?</h2>
<p>Those are usually content-named — <code>logo-v2.webp</code> rather than <code>logo.webp</code> — so a change already produces a new URL. If you overwrite an image in place, version it the same way or rename it.</p>

<h2>Verify it, do not assume it</h2>
<pre><code>curl -sS https://yoursite.com/ | grep -o 'css/[a-z]*\.css?v=[0-9]*'
curl -sSI "https://yoursite.com/css/app.css?v=123" | grep -i cache-control</code></pre>
<p>You want a version stamp in the HTML and a long <code>max-age</code> on the asset. Repeat visitors then download nothing at all, and a deploy is visible immediately.</p>

<p>If you are running on shared hosting, this pairs with two other things that catch people out — see <a href="/blog/deploy-laravel-hostinger-shared-hosting">deploying Laravel on Hostinger shared hosting</a> and <a href="/blog/laravel-storage-link-symlink-disabled-shared-hosting">fixing uploads when symlink() is disabled</a>.</p>
HTML,
            ],
            [
                'slug' => 'laravel-rest-api-tutorial',
                'title' => 'Building a Production-Ready REST API in Laravel',
                'category' => 'laravel',
                'read_minutes' => 11,
                'published_at' => Carbon::now()->subDays(2),
                'excerpt' => 'Routes, resources, validation, authentication, pagination, error handling and versioning — how to build a Laravel REST API that survives contact with a real client app.',
                'body' => <<<'HTML'
<p>Most Laravel API tutorials stop at returning a model from a controller. That works until a mobile app hits it, a field gets renamed, an error needs a consistent shape, or somebody asks for pagination. This walks the parts that actually matter once real clients depend on it.</p>

<h2>Start with routes that will still make sense later</h2>
<p>Put the API on its own file and version it from day one. Adding <code>/v2</code> later without breaking existing apps is nearly impossible if everything sits at the root.</p>
<pre><code>// routes/api.php
Route::prefix('v1')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::post('login', [AuthController::class, 'login']);
});</code></pre>
<p><code>apiResource</code> gives you index, store, show, update and destroy without the two form routes a web resource adds.</p>

<h2>Never return models directly</h2>
<p>Returning <code>Project::all()</code> exposes every column — including anything you add later, which is how internal notes end up in a public response. API Resources put a deliberate shape in between.</p>
<pre><code>class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' =&gt; $this-&gt;id,
            'title' =&gt; $this-&gt;title,
            'category' =&gt; $this-&gt;category,
            'tech_stack' =&gt; $this-&gt;tech_stack,
            'published_at' =&gt; $this-&gt;created_at-&gt;toIso8601String(),
        ];
    }
}</code></pre>
<p>Now a column rename is a one-line change in the resource instead of a breaking change for every consumer.</p>

<h2>Validate in a form request</h2>
<p>Validating inside the controller buries the rules and makes them impossible to reuse.</p>
<pre><code>class StoreProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' =&gt; ['required', 'string', 'max:180'],
            'category' =&gt; ['required', 'in:web,api,wordpress,mobile'],
            'tech_stack' =&gt; ['array'],
            'tech_stack.*' =&gt; ['string', 'max:40'],
        ];
    }
}</code></pre>
<p>Laravel returns a 422 with a field-keyed error object automatically — which is exactly the shape a frontend wants.</p>

<h2>Authentication: pick the simpler one</h2>
<p>For a first-party app — your own React frontend or mobile client — <strong>Sanctum</strong> is the right answer. Passport implements full OAuth2 and is worth its complexity only when third parties need to authorise against your API on behalf of users.</p>
<pre><code>public function login(Request $request)
{
    $request-&gt;validate(['email' =&gt; 'required|email', 'password' =&gt; 'required']);

    $user = User::where('email', $request-&gt;email)-&gt;first();

    if (! $user || ! Hash::check($request-&gt;password, $user-&gt;password)) {
        return response()-&gt;json(['message' =&gt; 'Invalid credentials'], 401);
    }

    return response()-&gt;json([
        'token' =&gt; $user-&gt;createToken('api')-&gt;plainTextToken,
    ]);
}</code></pre>
<p>Protect routes with <code>auth:sanctum</code>, and give tokens abilities if different clients should not have the same reach.</p>

<h2>Paginate before the table grows</h2>
<p>An endpoint returning every row is fine with 40 records and a problem with 40,000. Paginate from the start — the response shape changes when you add it, so doing it later breaks clients.</p>
<pre><code>return ProjectResource::collection(
    Project::query()-&gt;latest()-&gt;paginate($request-&gt;integer('per_page', 15))
);</code></pre>
<p>Cap <code>per_page</code>. Without a limit, <code>?per_page=100000</code> is a denial-of-service anyone can trigger.</p>

<h2>Make every error look the same</h2>
<p>A client should never have to parse an HTML error page. Force JSON for API routes:</p>
<pre><code>// bootstrap/app.php
-&gt;withExceptions(function (Exceptions $exceptions) {
    $exceptions-&gt;shouldRenderJsonWhen(
        fn ($request) =&gt; $request-&gt;is('api/*')
    );
})</code></pre>
<p>Then a missing record returns a JSON 404 rather than a rendered page, and the frontend can handle every failure the same way.</p>

<h2>Watch the query count</h2>
<p>Returning 15 projects that each load a relation is 16 queries. This is the single most common reason an API feels slow, and it does not show up until the table fills. Eager load what the resource touches:</p>
<pre><code>Project::with('skills')-&gt;paginate(15);</code></pre>
<p>I wrote about spotting these in <a href="/blog/laravel-n1-query-problem">finding and fixing N+1 queries in Eloquent</a>.</p>

<h2>Rate limit public endpoints</h2>
<pre><code>Route::middleware('throttle:60,1')-&gt;group(function () {
    // 60 requests per minute per user or IP
});</code></pre>
<p>Login endpoints deserve something much tighter — five attempts per minute makes credential stuffing impractical.</p>

<h2>Before you call it done</h2>
<ul>
<li>Versioned routes, so v2 does not break v1</li>
<li>Resources between models and responses</li>
<li>Form requests holding the validation rules</li>
<li>Sanctum tokens, with abilities where they matter</li>
<li>Pagination with a capped page size</li>
<li>JSON errors for every failure path</li>
<li>Eager loading verified by query count, not assumed</li>
<li>Rate limits, strictest on auth</li>
</ul>
<p>None of this is exotic. It is the difference between an endpoint that demos well and one a client's app can depend on.</p>
HTML,
            ],

            [
                'slug' => 'laravel-n1-query-problem',
                'title' => 'Fixing N+1 Queries in Laravel Eloquent',
                'category' => 'laravel',
                'read_minutes' => 7,
                'published_at' => Carbon::now()->subDays(5),
                'excerpt' => 'A page that runs 200 queries instead of 3 is almost always an N+1. How to spot them, fix them with eager loading, and stop them coming back.',
                'body' => <<<'HTML'
<p>A page loads fine in development with twelve records and crawls in production with twelve hundred. Nothing changed in the code. What changed is how many times one query inside a loop ran.</p>

<h2>What an N+1 actually is</h2>
<p>You fetch a list, then touch a relation on each item:</p>
<pre><code>$projects = Project::all();          // 1 query

foreach ($projects as $project) {
    echo $project-&gt;client-&gt;name;      // 1 query — each time round
}</code></pre>
<p>Twelve projects is 13 queries. Twelve hundred is 1,201. The code reads perfectly well, which is why this survives review.</p>

<h2>Seeing it</h2>
<p>Count queries rather than guessing. Log them in a local service provider:</p>
<pre><code>// AppServiceProvider::boot(), local only
if (app()-&gt;environment('local')) {
    DB::listen(fn ($q) =&gt; logger($q-&gt;sql));
}</code></pre>
<p>Load the page and count the lines. If one statement repeats with only the id changing, that is your N+1. Laravel Debugbar and Telescope show the same thing with less setup.</p>

<h3>Make Laravel refuse to do it</h3>
<p>Better than finding them by hand — have the framework throw when a relation loads lazily:</p>
<pre><code>// AppServiceProvider::boot()
Model::preventLazyLoading(! app()-&gt;isProduction());</code></pre>
<p>Now an N+1 fails loudly in development instead of quietly in production. Turn it on in an existing project and expect to find several immediately.</p>

<h2>The fix</h2>
<pre><code>$projects = Project::with('client')-&gt;get();   // 2 queries, whatever the count</code></pre>
<p>Laravel fetches every client in one <code>whereIn</code> and matches them up. Two queries for twelve rows, and two for twelve hundred.</p>

<h3>Nested and multiple relations</h3>
<pre><code>Project::with(['client', 'tasks.assignee'])-&gt;get();</code></pre>

<h3>Load only the columns you use</h3>
<pre><code>Project::with('client:id,name')-&gt;get();</code></pre>
<p>Include the foreign key — leave <code>id</code> out and the relation cannot be matched, and the relation comes back null with no error.</p>

<h2>Counting without loading</h2>
<p>To show how many tasks a project has, do not load the tasks:</p>
<pre><code>$projects = Project::withCount('tasks')-&gt;get();
// $project-&gt;tasks_count</code></pre>
<p>One aggregate query instead of pulling every row into memory to call <code>count()</code> on it.</p>

<h2>When eager loading is the wrong fix</h2>
<p>Eager loading trades queries for memory. Loading a relation for 50,000 rows to display ten of them just moves the problem. In that case paginate first, or select the few columns you need with a join.</p>
<p>Chunk long-running jobs rather than eager loading everything:</p>
<pre><code>Project::with('client')-&gt;chunk(200, function ($projects) {
    // 200 at a time, memory stays flat
});</code></pre>

<h2>Keeping them out</h2>
<ul>
<li>Turn on <code>preventLazyLoading</code> outside production</li>
<li>Check the query count when a page feels slow, before optimising anything else</li>
<li>Eager load in the controller, not the view — a view that triggers queries hides them</li>
<li>Use <code>withCount</code> for totals</li>
</ul>
<p>Most "Laravel is slow" reports are one of these. Fix the query count first; if it is still slow after that, then look at <a href="/blog/mysql-indexing-laravel">indexes</a>.</p>
HTML,
            ],

            [
                'slug' => 'mysql-indexing-laravel',
                'title' => 'MySQL Indexing Mistakes That Slow Down Laravel Apps',
                'category' => 'database',
                'read_minutes' => 8,
                'published_at' => Carbon::now()->subDays(9),
                'excerpt' => 'Your queries are fine and the app is still slow. Usually it is a missing index, an unusable one, or too many. How to read EXPLAIN and fix the common cases.',
                'body' => <<<'HTML'
<p>You have removed the N+1s, the page still takes two seconds, and the query log shows one statement taking most of it. That is an index problem, and it does not appear until the table has real data in it.</p>

<h2>Find the slow query first</h2>
<p>Do not optimise by intuition. Ask MySQL what it is doing:</p>
<pre><code>EXPLAIN SELECT * FROM projects WHERE category = 'web' ORDER BY created_at DESC LIMIT 15;</code></pre>
<p>Two columns matter:</p>
<ul>
<li><strong>type</strong> — <code>ALL</code> means a full table scan. Anything else is better.</li>
<li><strong>rows</strong> — roughly how many rows are examined. If that is near the table size to return 15, there is no useful index.</li>
</ul>

<h2>Mistake 1: no index on what you filter by</h2>
<p>Foreign keys usually get one from the migration. Status and category columns rarely do:</p>
<pre><code>Schema::table('projects', function (Blueprint $table) {
    $table-&gt;index('category');
    $table-&gt;index('is_active');
});</code></pre>
<p>Index the columns that appear in <code>where</code>, <code>order by</code> and <code>join</code> — not every column.</p>

<h2>Mistake 2: an index the query cannot use</h2>
<p>An index on <code>created_at</code> is useless here:</p>
<pre><code>WHERE DATE(created_at) = '2026-08-15'</code></pre>
<p>Wrapping the column in a function forces a scan of every row. Compare against a range instead:</p>
<pre><code>WHERE created_at &gt;= '2026-08-15 00:00:00'
  AND created_at &lt;  '2026-08-16 00:00:00'</code></pre>
<p>In Eloquent:</p>
<pre><code>// scans everything
Project::whereDate('created_at', $date)-&gt;get();

// uses the index
Project::whereBetween('created_at', [
    $date-&gt;copy()-&gt;startOfDay(),
    $date-&gt;copy()-&gt;endOfDay(),
])-&gt;get();</code></pre>
<p>The same applies to <code>LIKE '%term%'</code> — a leading wildcard cannot use an index. For real text search, use a FULLTEXT index or a search engine.</p>

<h2>Mistake 3: column order in a composite index</h2>
<p>A composite index works left to right. Given:</p>
<pre><code>$table-&gt;index(['is_active', 'category']);</code></pre>
<p>MySQL can use it for <code>is_active</code>, or for <code>is_active AND category</code> — but <strong>not</strong> for <code>category</code> alone. Put the column used in every query first, and the most selective one before the less selective.</p>

<h2>Mistake 4: indexing everything</h2>
<p>Every index has to be updated on write and takes disk. A table with fifteen indexes has slow inserts and a confused planner. Find the ones nobody uses:</p>
<pre><code>SELECT * FROM sys.schema_unused_indexes;</code></pre>

<h2>Mistake 5: ORDER BY forcing a filesort</h2>
<p>Filtering on one column and sorting by another, with separate indexes on each, still sorts in memory. A composite covering both lets the index do it:</p>
<pre><code>$table-&gt;index(['category', 'created_at']);</code></pre>
<p>Now <code>WHERE category = ? ORDER BY created_at DESC</code> is served by one index, and <code>Using filesort</code> disappears from EXPLAIN.</p>

<h2>A practical order of work</h2>
<ol>
<li>Log queries and find the slow one — do not guess</li>
<li>Run EXPLAIN; look at <code>type</code> and <code>rows</code></li>
<li>Add an index for the where and order columns</li>
<li>Re-run EXPLAIN and confirm it changed</li>
<li>Measure again with production-sized data</li>
</ol>
<p>Step five matters most. An index that helps with a thousand rows can be irrelevant at a million, and you will not know until you test at that size.</p>
<p>If your query count is still high, indexes are not your problem yet — start with <a href="/blog/laravel-n1-query-problem">N+1 queries</a>.</p>
HTML,
            ],

            [
                'slug' => 'speed-up-woocommerce-store',
                'title' => 'Why Your WooCommerce Store Is Slow (And How to Fix It)',
                'category' => 'wordpress',
                'read_minutes' => 8,
                'published_at' => Carbon::now()->subDays(15),
                'excerpt' => 'WooCommerce stores get slow for a handful of predictable reasons — plugin bloat, an unindexed postmeta table, uncached carts and oversized images. Here is what to check.',
                'body' => <<<'HTML'
<p>A WooCommerce store that loaded fine at launch is crawling a year later. The hosting did not change and neither did the theme. What changed is the number of products, orders and plugins — and WooCommerce gets slow in predictable ways.</p>

<h2>1. Plugins doing work on every page</h2>
<p>The usual culprit. Thirty plugins is not automatically a problem; one badly written plugin running a query on every request is. Install Query Monitor, load a product page, and look at which plugin owns the slowest queries.</p>
<p>Watch for plugins that:</p>
<ul>
<li>load their scripts on every page instead of the pages they are used on</li>
<li>write to <code>wp_options</code> on each request</li>
<li>add autoloaded options that grow without bound</li>
</ul>
<p>Check that last one directly:</p>
<pre><code>SELECT SUM(LENGTH(option_value))/1024/1024 AS mb
FROM wp_options WHERE autoload = 'yes';</code></pre>
<p>Anything over about 1 MB is loaded on every single request. I have seen 40 MB from a plugin that never cleaned up after itself.</p>

<h2>2. The postmeta table</h2>
<p>WooCommerce stores product attributes, order details and much else in <code>wp_postmeta</code>. On a store with a few thousand products that table reaches millions of rows, and queries filtering by <code>meta_key</code> scan it.</p>
<p>Confirm the standard index exists — some migrations lose it:</p>
<pre><code>SHOW INDEX FROM wp_postmeta;</code></pre>
<p>You want one on <code>meta_key</code>. Then clear what should not be there:</p>
<pre><code>DELETE pm FROM wp_postmeta pm
LEFT JOIN wp_posts p ON p.ID = pm.post_id
WHERE p.ID IS NULL;</code></pre>
<p>That removes metadata belonging to posts that no longer exist. Back up before running it.</p>

<h3>Turn on HPOS</h3>
<p>Recent WooCommerce can store orders in dedicated tables instead of the posts table. On a store with order history it is a large win. WooCommerce → Settings → Advanced → Features → High-performance order storage.</p>

<h2>3. Caching the wrong pages</h2>
<p>Full-page caching is what makes WordPress fast, but cart, checkout and account pages must never be cached — a cached cart shows one customer another customer's basket.</p>
<p>Every caching plugin has an exclusion list. Make sure it contains <code>/cart</code>, <code>/checkout</code>, <code>/my-account</code> and anything with <code>?add-to-cart</code>. Then test it: add a product in one browser, open the site in a private window, and confirm the cart is empty.</p>

<h2>4. Cart fragments on every page</h2>
<p>WooCommerce refreshes the mini-cart with an AJAX call, and by default it runs on <em>every</em> page — including ones with no cart on them. It is uncacheable and often the slowest request on a page.</p>
<pre><code>add_action('wp_enqueue_scripts', function () {
    if (! is_woocommerce() &amp;&amp; ! is_cart() &amp;&amp; ! is_checkout()) {
        wp_dequeue_script('wc-cart-fragments');
    }
}, 11);</code></pre>
<p>If your header shows a live cart count everywhere, leave it enabled — that is the trade.</p>

<h2>5. Images</h2>
<p>Product photos uploaded straight from a camera are frequently 3–4 MB each. Twenty on a category page is 60 MB before anything else loads.</p>
<ul>
<li>Serve WebP</li>
<li>Size them to what the theme displays, not the original dimensions</li>
<li>Lazy load anything below the fold</li>
<li>Set explicit width and height so the layout does not jump</li>
</ul>
<p>This is usually the single biggest gain on a product page, and the easiest.</p>

<h2>6. Scheduled tasks piling up</h2>
<p>WordPress runs cron on page loads by default, so a visitor pays for whatever is due. On a busy store, disable that and run it from a real cron job:</p>
<pre><code>// wp-config.php
define('DISABLE_WP_CRON', true);</code></pre>
<pre><code>*/5 * * * * curl -s https://yourstore.com/wp-cron.php?doing_wp_cron &gt;/dev/null 2&gt;&amp;1</code></pre>
<p>Also check WooCommerce → Status → Scheduled Actions. Tens of thousands of pending actions means something is failing and retrying forever.</p>

<h2>Where to start</h2>
<ol>
<li>Query Monitor on a product page — find the slowest queries and who owns them</li>
<li>Check autoloaded options size</li>
<li>Confirm cart, checkout and account are excluded from cache</li>
<li>Compress and resize images</li>
<li>Enable HPOS if the store has order history</li>
</ol>
<p>Measure before and after each one. Changing five things at once tells you nothing about which mattered.</p>
HTML,
            ],
        ];
    }
}
