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
        ];
    }
}
