<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skill;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@ahsannawaz.dev'],
            [
                'name'     => 'Ahsan Nawaz',
                'password' => Hash::make('Admin@123'),
            ]
        );

        // ── Skills ──────────────────────────────────────────────────
        $skills = [
            // Backend
            ['name'=>'Laravel','category'=>'backend','percentage'=>95,'level'=>'expert','icon'=>'🔥','color'=>'#F97316','color_gradient'=>'linear-gradient(90deg,#F97316,#fb923c)','sort_order'=>1],
            ['name'=>'PHP','category'=>'backend','percentage'=>93,'level'=>'expert','icon'=>'🐘','color'=>'#7c3aed','color_gradient'=>'linear-gradient(90deg,#7c3aed,#a78bfa)','sort_order'=>2],
            ['name'=>'REST API','category'=>'backend','percentage'=>90,'level'=>'advanced','icon'=>'🔗','color'=>'#2563eb','color_gradient'=>'linear-gradient(90deg,#2563eb,#60a5fa)','sort_order'=>3],
            // Frontend
            ['name'=>'React JS','category'=>'frontend','percentage'=>88,'level'=>'advanced','icon'=>'⚛️','color'=>'#0891b2','color_gradient'=>'linear-gradient(90deg,#0891b2,#22d3ee)','sort_order'=>4],
            ['name'=>'HTML5 / CSS3','category'=>'frontend','percentage'=>97,'level'=>'expert','icon'=>'🎨','color'=>'#F97316','color_gradient'=>'linear-gradient(90deg,#F97316,#fb923c)','sort_order'=>5],
            ['name'=>'JavaScript','category'=>'frontend','percentage'=>91,'level'=>'expert','icon'=>'✨','color'=>'#b45309','color_gradient'=>'linear-gradient(90deg,#b45309,#fbbf24)','sort_order'=>6],
            ['name'=>'jQuery','category'=>'frontend','percentage'=>94,'level'=>'expert','icon'=>'💡','color'=>'#4338ca','color_gradient'=>'linear-gradient(90deg,#4338ca,#818cf8)','sort_order'=>7],
            ['name'=>'Tailwind CSS','category'=>'frontend','percentage'=>87,'level'=>'advanced','icon'=>'🌊','color'=>'#0891b2','color_gradient'=>'linear-gradient(90deg,#0891b2,#22d3ee)','sort_order'=>8],
            ['name'=>'Bootstrap','category'=>'frontend','percentage'=>93,'level'=>'advanced','icon'=>'🅱️','color'=>'#7c3aed','color_gradient'=>'linear-gradient(90deg,#7c3aed,#a78bfa)','sort_order'=>9],
            // CMS
            ['name'=>'WordPress','category'=>'cms','percentage'=>92,'level'=>'expert','icon'=>'📝','color'=>'#1d4ed8','color_gradient'=>'linear-gradient(90deg,#1d4ed8,#60a5fa)','sort_order'=>10],
            ['name'=>'Plugin Dev','category'=>'cms','percentage'=>90,'level'=>'expert','icon'=>'🔌','color'=>'#F97316','color_gradient'=>'linear-gradient(90deg,#F97316,#fb923c)','sort_order'=>11],
            ['name'=>'Theme Dev','category'=>'cms','percentage'=>88,'level'=>'advanced','icon'=>'🎭','color'=>'#059669','color_gradient'=>'linear-gradient(90deg,#059669,#34d399)','sort_order'=>12],
            // Database
            ['name'=>'MySQL','category'=>'database','percentage'=>92,'level'=>'expert','icon'=>'🗄️','color'=>'#F97316','color_gradient'=>'linear-gradient(90deg,#F97316,#fb923c)','sort_order'=>13],
            ['name'=>'MongoDB','category'=>'database','percentage'=>70,'level'=>'good','icon'=>'🍃','color'=>'#059669','color_gradient'=>'linear-gradient(90deg,#059669,#34d399)','sort_order'=>14],
            ['name'=>'DB Design','category'=>'database','percentage'=>85,'level'=>'advanced','icon'=>'📊','color'=>'#2563eb','color_gradient'=>'linear-gradient(90deg,#2563eb,#60a5fa)','sort_order'=>15],
            // Tools
            ['name'=>'Git / GitHub','category'=>'tools','percentage'=>92,'level'=>'expert','icon'=>'🐙','color'=>'#b45309','color_gradient'=>'linear-gradient(90deg,#b45309,#fbbf24)','sort_order'=>16],
            ['name'=>'Docker','category'=>'tools','percentage'=>75,'level'=>'advanced','icon'=>'🐳','color'=>'#0891b2','color_gradient'=>'linear-gradient(90deg,#0891b2,#22d3ee)','sort_order'=>17],
            ['name'=>'Composer / NPM','category'=>'tools','percentage'=>94,'level'=>'advanced','icon'=>'🚀','color'=>'#F97316','color_gradient'=>'linear-gradient(90deg,#F97316,#fb923c)','sort_order'=>18],
            ['name'=>'AWS / cPanel','category'=>'tools','percentage'=>78,'level'=>'good','icon'=>'☁️','color'=>'#7c3aed','color_gradient'=>'linear-gradient(90deg,#7c3aed,#a78bfa)','sort_order'=>19],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }

        // ── Projects ─────────────────────────────────────────────────
        $projects = [
            [
                'title'       => 'SaaS CRM Platform',
                'description' => 'A full-scale multi-tenant CRM built with Laravel 11, featuring role-based access, Stripe billing, REST API, and real-time notifications.',
                'image'       => null,
                'tech_stack'  => ['Laravel','MySQL','Stripe API','React JS','Tailwind CSS'],
                'live_url'    => '#',
                'github_url'  => '#',
                'category'    => 'web',
                'is_featured' => true,
                'sort_order'  => 1,
            ],
            [
                'title'       => 'WooCommerce Custom Plugin',
                'description' => 'Custom WordPress plugin extending WooCommerce with advanced product configurator, custom checkout flow, and PayPal integration.',
                'image'       => null,
                'tech_stack'  => ['WordPress','PHP','WooCommerce','jQuery','MySQL'],
                'live_url'    => '#',
                'github_url'  => '#',
                'category'    => 'wordpress',
                'is_featured' => true,
                'sort_order'  => 2,
            ],
            [
                'title'       => 'React Admin Dashboard',
                'description' => 'A feature-rich admin dashboard with charts, CRUD tables, role management, dark/light modes, and REST API consumption.',
                'image'       => null,
                'tech_stack'  => ['React JS','Redux','Tailwind CSS','REST API','Chart.js'],
                'live_url'    => '#',
                'github_url'  => '#',
                'category'    => 'web',
                'is_featured' => true,
                'sort_order'  => 3,
            ],
            [
                'title'       => 'Laravel REST API',
                'description' => 'Scalable REST API with Sanctum auth, versioning, rate limiting, Postman docs, and third-party integrations (Stripe, Twilio, SendGrid).',
                'image'       => null,
                'tech_stack'  => ['Laravel','PHP','MySQL','Sanctum','Postman'],
                'live_url'    => '#',
                'github_url'  => '#',
                'category'    => 'api',
                'is_featured' => false,
                'sort_order'  => 4,
            ],
            [
                'title'       => 'E-Commerce Store',
                'description' => 'Full-featured e-commerce platform with product management, cart, checkout, payment gateway, and order tracking built on Laravel.',
                'image'       => null,
                'tech_stack'  => ['Laravel','MySQL','Stripe','Bootstrap','jQuery'],
                'live_url'    => '#',
                'github_url'  => '#',
                'category'    => 'web',
                'is_featured' => false,
                'sort_order'  => 5,
            ],
            [
                'title'       => 'WordPress Theme',
                'description' => 'Custom WordPress theme with Elementor compatibility, performance optimisation (99 PageSpeed), WPML multi-language, and WooCommerce support.',
                'image'       => null,
                'tech_stack'  => ['WordPress','PHP','CSS3','Elementor','ACF Pro'],
                'live_url'    => '#',
                'github_url'  => '#',
                'category'    => 'wordpress',
                'is_featured' => false,
                'sort_order'  => 6,
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(['title' => $project['title']], $project);
        }
    }
}
