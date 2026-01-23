<?php

namespace Modules\Post\database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Post\Enums\PostStatus;
use Modules\Post\Enums\PostType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Post\Models\Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $articles = [
            [
                'name' => 'Pesona Alam Curug Putri Palutungan',
                'intro' => 'Curug Putri Palutungan menawarkan keindahan air terjun di kaki Gunung Ciremai yang memanjakan mata.',
                'content' => '<p>Curug Putri Palutungan terletak di Desa Cisantana, Kecamatan Cigugur, Kabupaten Kuningan. Air terjun ini menawarkan pemandangan alam yang asri dengan udara yang sejuk khas pegunungan.  Dipercaya sebagai tempat pemandian para putri dari kahyangan, curug ini memiliki daya tarik tersendiri bagi wisatawan yang ingin melepas penat.</p><p>Fasilitas di sekitar area wisata juga sudah cukup lengkap, mulai dari area parkir, mushola, hingga warung-warung yang menjajakan makanan hangat. Bagi pecinta fotografi, banyak spot menarik yang bisa diabadikan di sini.</p>',
                'image' => 'https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/13/2023/10/26/Curug-Putri-Palutungan-379203649.jpg'
            ],
            [
                'name' => 'Menjelajahi Sejarah di Gedung Perundingan Linggarjati',
                'intro' => 'Saksi bisu diplomasi Indonesia dalam mempertahankan kemerdekaan, Gedung Perundingan Linggarjati wajib dikunjungi.',
                'content' => '<p>Gedung Perundingan Linggarjati di Cilimus, Kuningan, adalah tempat bersejarah di mana perjanjian antara Indonesia dan Belanda ditandatangani pada tahun 1946. Bangunan ini masih terawat dengan baik dan kini difungsikan sebagai museum.</p><p>Pengunjung dapat melihat ruang siding, ruang istirahat delegasi, dan perabotan asli yang digunakan saat perundingan berlangsung. Mengunjungi tempat ini seolah membawa kita kembali ke masa perjuangan diplomasi bangsa.</p>',
                 'image' => 'https://asset.kompas.com/crops/OqWqT-QXXK-gXNY9iGdaS-dO1s8=/0x0:780x520/750x500/data/photo/2020/08/21/5f3f90e513814.jpg'
            ],
            [
                'name' => 'Nikmatnya Hucap, Sarapan Khas Kuningan yang Legendaris',
                'intro' => 'Hucap atau Tahu Kecap adalah menu sarapan wajib jika berkunjung ke Kuningan. Perpaduan tahu dan bumbu kacang yang khas.',
                'content' => '<p>Hucap merupakan singkatan dari Tahu Kecap. Kuliner ini sekilas mirip dengan kupat tahu, namun memiliki ciri khas pada bumbu kacangnya yang lebih kental dan rasa manis gurih yang dominan dari kecap lokal Kuningan.</p><p>Biasanya Hucap disajikan dengan taburan bawang goreng yang melimpah. Salah satu Hucap legendaris bisa ditemukan di sekitar pasar pusat kota Kuningan.</p>',
                'image' => 'https://assets.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/2022/09/16/2324672614.jpg'
            ],
             [
                'name' => 'Keindahan Telaga Biru Cicerem yang Memukau',
                'intro' => 'Telaga dengan air jernih berwarna biru dan ribuan ikan yang berenang bebas, spot foto favorit di Kuningan.',
                'content' => '<p>Telaga Biru Cicerem di Kaduela dikenal karena airnya yang sangat jernih hingga dasar danau terlihat. Ikan-ikan berwarna-warni yang hidup di dalamnya menambah pesona tempat ini.</p><p>Pengunjung bisa berswafoto di ayunan yang tergantung di atas danau, memberikan hasil foto yang instagramable. Suasana yang tenang membuat tempat ini cocok untuk healing.</p>',
                'image' => 'https://asset.kompas.com/crops/TyVqL9zGPrgC9zYgN-uXhCg9p_4=/0x0:1000x667/750x500/data/photo/2020/02/24/5e533b6d0c2bd.jpg'
            ],
            [
                'name' => 'Tape Ketan Kuningan: Manis Asem Segar dalam Ember Kecil',
                'intro' => 'Oleh-oleh ikonik khas Kuningan yang terbuat dari beras ketan yang difermentasi dengan ragi dan daun katuk.',
                'content' => '<p>Tape Ketan Kuningan terkenal dengan kemasannya yang menggunakan ember hitam kecil. Rasanya yang manis dengan sedikit rasa asam hasil fermentasi serta aroma wangi daun katuk membuatnya sangat digemari.</p><p>Tape ini sangat nikmat disantap langsung atau dijadikan campuran es doger. Sentra produksi tape ketan banyak ditemui di daerah Cibentang dan Taraju.</p>',
                'image' => 'https://radarkuningan.disway.id/upload/54b732488d0714247514cb9547d7c677.jpg'
            ],
            [
                'name' => 'Geliat Batik Kuningan: Motif Kuda Si Windu yang Khas',
                'intro' => 'Batik Kuningan memiliki motif-motif unik yang mengangkat kearifan lokal seperti Kuda Si Windu dan Ikan Dewa.',
                'content' => '<p>UMKM Batik di Kuningan terus berkembang dengan inovasi motif yang mengangkat ikon daerah. Motif Kuda Si Windu, Bokor, dan Ikan Dewa menjadi identitas visual yang membedakan Batik Kuningan dengan daerah lain.</p><p>Para pengrajin batik di desa-desa mulai memasarkan produknya secara digital, menjangkau pasar yang lebih luas hingga ke mancanegara.</p>',
                'image' => 'https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/01/2023/10/02/Batik-Kuningan-3788722240.jpg'
            ],
            [
                 'name' => 'Waduk Darma: Destinasi Wisata Air Keluarga',
                 'intro' => 'Nikmati keindahan pemandangan waduk yang luas cocok untuk wisata keluarga dan watersport.',
                 'content' => '<p>Waduk Darma tidak hanya berfungsi sebagai bendungan irigasi, tetapi juga menjadi destinasi wisata unggulan di Kuningan. Dengan fasilitas yang terus dibenahi, pengunjung kini bisa menikmati perahu wisata, area bermain anak, dan spot foto yang menarik.</p><p>Pemandangan matahari terbenam atau sunset di Waduk Darma menjadi salah satu momen yang paling ditunggu oleh wisatawan.</p>',
                 'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_xNq4zI0-V3a_z-r2M2q-K3k7hJ8h_g&s'
            ],
            [
                'name' => 'Nasi Kasreng: Kuliner Sederhana Rasa Istimewa',
                'intro' => 'Nasi bungkus khas Luragung dengan lauk sederhana namun rasa yang ngangenin.',
                'content' => '<p>Nasi Kasreng adalah kuliner khas dari Kecamatan Luragung. Terdiri dari nasi putih yang disajikan dengan toge rebus, taburan udang rebon (hurang), dan sambal terasi yang super pedas.</p><p>Biasanya dilengkapi dengan aneka gorengan hangat seperti gorengan tempe, bala-bala, atau gehu. Harganya yang sangat terjangkau menjadikannya favorit semua kalangan.</p>',
                'image' => 'https://static.promediateknologi.id/crop/0x0:0x0/750x500/photo/2022/10/01/3576435252.jpg'
            ],
        ];

        $article = $this->faker->randomElement($articles);

        return [
            'name' => $article['name'],
            'slug' => Str::slug($article['name']) . '-' . rand(1, 1000),
            'intro' => $article['intro'],
            'content' => $article['content'],
            'type' => PostType::Article->value,
            'is_featured' => $this->faker->randomElement([1, 0]),
            'image' => $article['image'],
            'status' => PostStatus::Published->value,
            'category_id' => $this->faker->numberBetween(1, 4),
            'meta_title' => $article['name'],
            'meta_keywords' => str_replace(' ', ',', $article['name']),
            'meta_description' => $article['intro'],
            'created_by_name' => 'Admin Kuniverse',
            'created_at' => Carbon::now()->subDays(rand(0, 30)),
            'updated_at' => Carbon::now(),
            'published_at' => Carbon::now()->subDays(rand(0, 30)),
        ];
    }
}