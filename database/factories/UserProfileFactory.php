<?php

namespace Database\Factories;

use App\Models\Admin\System\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserProfile>
 */
class UserProfileFactory extends Factory
{
    protected $model = UserProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => fake()->numerify('35730##############'),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
            'gender' => fake()->randomElement(['Laki-Laki', 'Perempuan']),
            'religion' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'marital_status' => fake()->randomElement(['Belum Menikah', 'Menikah', 'Cerai']),
            'motto' => fake()->sentence(6),
            'cover_image' => null,
            'job_title' => fake()->randomElement([
                'Software Engineer',
                'Frontend Developer',
                'Backend Developer',
                'Full-Stack Developer',
                'UI/UX Designer',
                'Product Manager',
                'Data Analyst',
                'System Administrator',
                'QA Engineer',
                'DevOps Specialist'
            ]),
            'education' => fake()->randomElement([
                'S1 Teknik Informatika',
                'S1 Sistem Informasi',
                'S1 Desain Komunikasi Visual',
                'D3 Manajemen Informatika',
                'S1 Ilmu Komputer',
                'Stanford University',
                'Universitas Gadjah Mada',
                'Institut Teknologi Bandung'
            ]),
            'location' => fake()->city() . ', Indonesia',
            'address' => fake()->streetAddress(),
            'rt' => sprintf('%03d', fake()->numberBetween(1, 15)),
            'rw' => sprintf('%03d', fake()->numberBetween(1, 10)),
            'village' => fake()->streetName(),
            'district' => fake()->city(),
            'city_regency' => fake()->city(),
            'province' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'phone' => fake()->phoneNumber(),
            'website' => 'https://' . fake()->domainName(),
            'languages' => ['Bahasa Indonesia', 'English'],
            'about_me' => fake()->paragraph(3),
            'skills' => fake()->randomElements([
                'PHP', 'Laravel', 'Bootstrap 5', 'JavaScript', 'Vue.js', 'React.js',
                'MySQL', 'PostgreSQL', 'UI/UX', 'Tailwind CSS', 'Git', 'REST API', 'Docker'
            ], fake()->numberBetween(3, 6)),
            'social_links' => [
                'facebook' => 'https://facebook.com/' . fake()->userName(),
                'twitter' => 'https://x.com/' . fake()->userName(),
                'instagram' => 'https://instagram.com/' . fake()->userName(),
                'linkedin' => 'https://linkedin.com/in/' . fake()->userName(),
                'github' => 'https://github.com/' . fake()->userName(),
            ],
        ];
    }
}
