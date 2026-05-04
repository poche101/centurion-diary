<?php

namespace Database\Seeders;

use App\Models\GivingLog;
use App\Models\PrayerLog;
use App\Models\Scripture;
use App\Models\Soul;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('users')) {
            $this->command->error('users table missing — run: php artisan migrate');
            return;
        }

        // Wipe in correct FK order
        DB::statement('PRAGMA foreign_keys = OFF');
        DB::table('giving_logs')->delete();
        DB::table('souls')->delete();
        DB::table('prayer_logs')->delete();
        DB::table('scriptures')->delete();
        DB::table('users')->delete();
        DB::statement('PRAGMA foreign_keys = ON');

        // ── Admin ─────────────────────────────────────────────────
        $admin = User::create([
            'full_name'     => 'Administrator',
            'email'         => 'admin@centuriondiary.com',
            'phone'         => '+2341234567890',
            'kingschat'     => '@admin',
            'group'         => 'Administration',
            'church'        => 'HQ Church',
            'password'      => Hash::make('password'),
            'prayer_time'   => '06:00',
            'is_admin'      => true,
            'last_login_at' => now(),
        ]);

        // ── Demo users ────────────────────────────────────────────
        $demos = [
            ['full_name' => 'Grace Okafor',  'email' => 'grace@demo.com',    'church' => 'Christ Embassy Lagos', 'group' => 'Zone A'],
            ['full_name' => 'David Eze',      'email' => 'david@demo.com',    'church' => 'Loveworld Nigeria',    'group' => 'Zone B'],
            ['full_name' => 'Faith Adeyemi',  'email' => 'faith@demo.com',    'church' => 'Christ Embassy Abuja', 'group' => 'Zone C'],
            ['full_name' => 'Emmanuel Obi',   'email' => 'emma@demo.com',     'church' => 'Loveworld UK',         'group' => 'UK Zone'],
            ['full_name' => 'Blessing Nwosu', 'email' => 'blessing@demo.com', 'church' => 'Christ Embassy PH',    'group' => 'PH Zone'],
        ];

        $prayerTypes = ['intercession', 'worship', 'tongues', 'meditation', 'general'];
        $categories  = ['tithe', 'offering', 'missions', 'welfare', 'building_fund', 'special_seed'];
        $soulNames   = ['John Smith', 'Mary Johnson', 'Peter Brown', 'Sarah Davis',
                        'Michael Wilson', 'Alice Moore', 'James Taylor', 'Emma Anderson'];

        foreach ($demos as $data) {
            $user = User::create([
                'full_name'     => $data['full_name'],
                'email'         => $data['email'],
                'phone'         => '+23480' . rand(10000000, 99999999),
                'kingschat'     => '@' . strtolower(explode(' ', $data['full_name'])[0]),
                'group'         => $data['group'],
                'church'        => $data['church'],
                'password'      => Hash::make('password'),
                'prayer_time'   => '06:00',
                'is_admin'      => false,
                'last_login_at' => now()->subHours(rand(0, 48)),
            ]);

            for ($i = 0; $i < rand(20, 50); $i++) {
                PrayerLog::create([
                    'user_id'          => $user->id,
                    'prayer_date'      => now()->subDays(rand(0, 90))->toDateString(),
                    'duration_minutes' => rand(30, 180),
                    'prayer_type'      => $prayerTypes[array_rand($prayerTypes)],
                    'notes'            => rand(0,1) ? 'Had a powerful session in the Spirit.' : null,
                ]);
            }

            for ($i = 0; $i < rand(5, 30); $i++) {
                Soul::create([
                    'user_id'         => $user->id,
                    'soul_name'       => $soulNames[array_rand($soulNames)] . ' ' . rand(1, 99),
                    'date_won'        => now()->subDays(rand(0, 90))->toDateString(),
                    'phone'           => rand(0,1) ? '+23480' . rand(10000000, 99999999) : null,
                    'location'        => collect(['Lagos','Abuja','Port Harcourt',null])->random(),
                    'baptized'        => (bool) rand(0, 1),
                    'follow_up_notes' => rand(0,1) ? 'Attending midweek service.' : null,
                ]);
            }

            for ($i = 0; $i < rand(5, 20); $i++) {
                GivingLog::create([
                    'user_id'       => $user->id,
                    'amount_espees' => round(rand(1, 20) + rand(0, 99) / 100, 2),
                    'category'      => $categories[array_rand($categories)],
                    'description'   => null,
                    'date_given'    => now()->subDays(rand(0, 90))->toDateString(),
                ]);
            }
        }

        // ── Scriptures — one unique date each, no duplicates ──────
        $scriptures = [
            ['reference' => 'Joshua 1:9',          'text' => 'Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.'],
            ['reference' => 'Philippians 4:13',     'text' => 'I can do all things through Christ who strengthens me.'],
            ['reference' => 'Proverbs 11:30',       'text' => 'The fruit of the righteous is a tree of life, and the one who is wise saves lives.'],
            ['reference' => 'Isaiah 40:31',         'text' => 'Those who hope in the Lord will renew their strength. They will soar on wings like eagles; they will run and not grow weary.'],
            ['reference' => 'Matthew 28:19',        'text' => 'Therefore go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit.'],
            ['reference' => '2 Corinthians 9:7',    'text' => 'God loves a cheerful giver.'],
            ['reference' => 'Romans 8:28',          'text' => 'In all things God works for the good of those who love him, who have been called according to his purpose.'],
            ['reference' => 'Jeremiah 29:11',       'text' => 'For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.'],
            ['reference' => '1 Thessalonians 5:17', 'text' => 'Pray without ceasing.'],
            ['reference' => 'Luke 10:2',            'text' => 'The harvest is plentiful, but the workers are few. Ask the Lord of the harvest to send out workers into his harvest field.'],
            ['reference' => 'Malachi 3:10',         'text' => 'Bring the whole tithe into the storehouse. Test me in this, says the Lord Almighty, and see if I will not throw open the floodgates of heaven.'],
            ['reference' => 'James 5:16',           'text' => 'The prayer of a righteous person is powerful and effective.'],
            ['reference' => 'Acts 1:8',             'text' => 'You will receive power when the Holy Spirit comes on you; and you will be my witnesses to the ends of the earth.'],
            ['reference' => 'Psalm 100:4',          'text' => 'Enter his gates with thanksgiving and his courts with praise; give thanks to him and praise his name.'],
        ];

        // Use a Set to guarantee no duplicate dates
        $usedDates = [];
        foreach ($scriptures as $i => $s) {
            $date = now()->subDays($i)->toDateString(); // e.g. "2026-05-03"

            // Skip if somehow duplicate (shouldn't happen, but safety net)
            if (in_array($date, $usedDates)) {
                continue;
            }
            $usedDates[] = $date;

            DB::table('scriptures')->insert([
                'date'       => $date,
                'reference'  => $s['reference'],
                'text'       => $s['text'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('');
        $this->command->info('  ✅  Centurion Diary seeded!');
        $this->command->info('  Admin : admin@centuriondiary.com / password');
        $this->command->info('  Demo  : grace@demo.com / password');
        $this->command->info('');
    }
}
