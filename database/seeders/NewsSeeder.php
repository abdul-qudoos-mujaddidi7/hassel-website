<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Mount Agro Institution Launches New Agricultural Development Program',
                'slug' => 'mount-agro-institution-launches-new-agricultural-development-program',
                'excerpt' => 'A comprehensive program designed to support sustainable farming practices and increase agricultural productivity across Afghanistan.',
                'content' => 'Mount Agro Institution is proud to announce the launch of our new Agricultural Development Program, specifically designed to support farmers across Afghanistan in adopting sustainable farming practices. This comprehensive program combines traditional knowledge with modern agricultural techniques to increase productivity while preserving environmental resources.

The program includes training workshops, technical assistance, access to improved seeds and equipment, and ongoing support for participating farmers. Our team of agricultural experts will work directly with farming communities to implement best practices in soil management, water conservation, and crop diversification.

Initial pilot projects have shown promising results, with participating farms experiencing an average 35% increase in crop yields while reducing water usage by 20%. The program is expected to reach over 5,000 farmers across 15 provinces in its first year.',
                'featured_image' => 'https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'created_at' => now()->subDays(5),
                'farsi_translations' => [
                    'title' => 'موسسه مونت آگرو برنامه جدید توسعه کشاورزی را راه‌اندازی می‌کند',
                    'excerpt' => 'برنامه جامعی که برای پشتیبانی از شیوه‌های کشاورزی پایدار و افزایش بهره‌وری کشاورزی در سراسر افغانستان طراحی شده است.',
                    'content' => 'موسسه مونت آگرو با افتخار راه‌اندازی برنامه جدید توسعه کشاورزی خود را اعلام می‌کند که به طور خاص برای پشتیبانی از کشاورزان در سراسر افغانستان در پذیرش شیوه‌های کشاورزی پایدار طراحی شده است. این برنامه جامع دانش سنتی را با تکنیک‌های کشاورزی مدرن ترکیب می‌کند تا بهره‌وری را افزایش دهد و در عین حال منابع محیطی را حفظ کند.

این برنامه شامل کارگاه‌های آموزشی، کمک‌های فنی، دسترسی به بذرها و تجهیزات بهبود یافته، و پشتیبانی مداوم از کشاورزان شرکت‌کننده است. تیم متخصصان کشاورزی ما مستقیماً با جوامع کشاورزی کار خواهند کرد تا بهترین شیوه‌ها در مدیریت خاک، حفاظت از آب، و تنوع‌بخشی محصولات را پیاده‌سازی کنند.

پروژه‌های آزمایشی اولیه نتایج امیدوارکننده‌ای نشان داده‌اند، با مزارع شرکت‌کننده که به طور متوسط 35٪ افزایش در عملکرد محصولات را تجربه کرده‌اند در حالی که استفاده از آب را 20٪ کاهش داده‌اند. انتظار می‌رود این برنامه در سال اول به بیش از 5000 کشاورز در 15 ولایت برسد.'
                ],
                'pashto_translations' => [
                    'title' => 'د مونت اګرو موسسه نوی کرنې د پرمختګ پروګرام پیل کوي',
                    'excerpt' => 'یو جامع پروګرام چې د پایدارو کرنې دودونو ملاتړ او د افغانستان په ټوله کې د کرنې د تولید د زیاتوالي لپاره ډیزاین شوی.',
                    'content' => 'د مونت اګرو موسسه د خپل نوي کرنې د پرمختګ پروګرام د پیل اعلان کولو سره د افتخار احساس کوي، چې په ځانګړي ډول د افغانستان په ټوله کې د کروندګرو د ملاتړ لپاره ډیزاین شوی ترڅو د پایدارو کرنې دودونه ومني. دا جامع پروګرام دودیزه پوهه د عصري کرنې د تخنیکونو سره ترکیب کوي ترڅو تولید زیات کړي پداسې حال کې چې د چاپیریال سرچینې ساتي.

پروګرام د روزنې ورکشاپونو، تخنیکي مرستو، د ښه شويو تخمونو او وسایلو لاسرسي، او د برخه اخیستونکو کروندګرو د دوامداره ملاتړ شاملوي. زموږ د کرنې پوهانو ټیم به مستقیم د کرنې ټولنو سره کار وکړي ترڅو د خاورې د مدیریت، د اوبو د ساتنې، او د محصولاتو د تنوع کولو کې غوره دودونه پلي کړي.

لومړني تجربوي پروژې د امیدوارو پایلو ښودل، د برخه اخیستونکو فارمونو سره چې په اوسط ډول 35٪ زیاتوالی د محصولاتو کې تجربه کړی پداسې حال کې چې د اوبو کارونه 20٪ کم کړي. تمه کیږي چې دا پروګرام به په لومړي کال کې د 15 ولایتونو په اوږدو کې د 5000 څخه زیاتو کروندګرو ته ورسي.'
                ]
            ],
            [
                'title' => 'Successful Harvest Season Results from Training Programs',
                'slug' => 'successful-harvest-season-results-from-training-programs',
                'excerpt' => 'Farmers who participated in our training programs report significant improvements in crop quality and yield.',
                'content' => 'The latest harvest season has brought excellent news from farmers who participated in Mount Agro Institution\'s training programs throughout the year. Across multiple provinces, participating farmers have reported substantial improvements in both crop quality and overall yield.

Key achievements include:
- Average yield increase of 40% for wheat crops
- 25% improvement in vegetable production quality
- Reduced post-harvest losses by 30%
- Enhanced soil health through sustainable practices

These results demonstrate the effectiveness of combining traditional farming wisdom with modern agricultural techniques. Our field teams have documented best practices and success stories that will be shared with the broader farming community.

The success of this season\'s harvest validates our approach to agricultural development and reinforces our commitment to supporting Afghanistan\'s farming communities. We look forward to expanding these programs to reach even more farmers in the coming year.',
                'featured_image' => 'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'created_at' => now()->subDays(15),
                'farsi_translations' => [
                    'title' => 'نتایج موفق فصل برداشت از برنامه‌های آموزشی',
                    'excerpt' => 'کشاورزانی که در برنامه‌های آموزشی ما شرکت کردند، بهبودهای قابل توجهی در کیفیت و عملکرد محصولات گزارش داده‌اند.',
                    'content' => 'آخرین فصل برداشت اخبار عالی از کشاورزانی که در طول سال در برنامه‌های آموزشی موسسه مونت آگرو شرکت کرده‌اند، به همراه آورده است. در سراسر ولایات متعدد، کشاورزان شرکت‌کننده بهبودهای قابل توجهی در هر دو کیفیت محصول و عملکرد کلی گزارش داده‌اند.

دستاوردهای کلیدی شامل:
- افزایش متوسط عملکرد 40٪ برای محصولات گندم
- بهبود 25٪ در کیفیت تولید سبزیجات
- کاهش 30٪ تلفات پس از برداشت
- بهبود سلامت خاک از طریق شیوه‌های پایدار

این نتایج اثربخشی ترکیب حکمت کشاورزی سنتی با تکنیک‌های کشاورزی مدرن را نشان می‌دهد. تیم‌های میدانی ما بهترین شیوه‌ها و داستان‌های موفقیت را مستند کرده‌اند که با جامعه گسترده‌تر کشاورزی به اشتراک گذاشته خواهد شد.

موفقیت برداشت این فصل رویکرد ما به توسعه کشاورزی را تأیید می‌کند و تعهد ما را برای پشتیبانی از جوامع کشاورزی افغانستان تقویت می‌کند. ما مشتاقیم این برنامه‌ها را گسترش دهیم تا در سال آینده به کشاورزان بیشتری برسیم.'
                ],
                'pashto_translations' => [
                    'title' => 'د روزنې پروګرامونو څخه د بریالۍ د حاصلاتو فصل پایلې',
                    'excerpt' => 'هغه کروندګر چې زموږ د روزنې پروګرامونو کې برخه اخیستې، د محصولاتو په کیفیت او تولید کې د پام وړ ښه والي راپور ورکړی.',
                    'content' => 'وروستی د حاصلاتو فصل د هغو کروندګرو څخه غوره خبرونه راوړي چې د کال په اوږدو کې د مونت اګرو موسسې د روزنې پروګرامونو کې برخه اخیستې. د څو ولایتونو په اوږدو کې، برخه اخیستونکو کروندګرو د محصولاتو په کیفیت او ټولیز تولید کې د پام وړ ښه والي راپور ورکړی.

کلیدي لاسته راوړنې شامل دي:
- د ګندم محصولاتو لپاره د تولید 40٪ اوسط زیاتوالی
- د سبزیاتو د تولید په کیفیت کې 25٪ ښه والی
- د حاصلاتو وروسته د تلفاتو 30٪ کمول
- د پایدارو دودونو له لارې د خاورې د روغتیا زیاتوالی

دا پایلې دودیزې کرنې د حکمت د عصري کرنې د تخنیکونو سره د ترکیب د اغیزمنتیا ښیي. زموږ د ميدان ټيمونو غوره دودونه او بریالۍ کیسې ثبت کړي چې د کرنې د پراخې ټولنې سره شریک به شي.

د دې فصل د حاصلاتو بریالیتوب زموږ د کرنې د پرمختګ لارښود تایید کوي او زموږ د افغانستان د کرنې ټولنو د ملاتړ تعهد پیاوړی کوي. موږ د دې پروګرامونو د پراخولو لپاره لیوال یو ترڅو راتلونکي کال کې نورو کروندګرو ته ورسي.'
                ]
            ],
            [
                'title' => 'Partnership with International Agricultural Research Center',
                'slug' => 'partnership-with-international-agricultural-research-center',
                'excerpt' => 'New collaboration brings cutting-edge research and technology to Afghan farmers.',
                'content' => 'Mount Agro Institution has entered into a strategic partnership with the International Center for Agricultural Research in Dry Areas (ICARDA) to bring advanced research and technology to Afghanistan\'s agricultural sector.

This partnership will focus on:
- Development of drought-resistant crop varieties
- Climate-smart agriculture techniques
- Soil and water conservation methods
- Capacity building for local researchers
- Technology transfer and innovation adoption

The collaboration includes joint research projects, training exchanges, and the establishment of demonstration farms where new techniques can be tested and refined for local conditions. This partnership represents a significant step forward in advancing agricultural science and practice in Afghanistan.

Initial projects will focus on developing wheat varieties better adapted to changing climate conditions and improving water use efficiency in irrigation systems. The partnership is expected to benefit thousands of farmers across the country through improved agricultural technologies and practices.',
                'featured_image' => 'https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
                'published_at' => now()->subDays(25),
                'created_at' => now()->subDays(25),
                'farsi_translations' => [
                    'title' => 'همکاری با مرکز بین‌المللی تحقیقات کشاورزی',
                    'excerpt' => 'همکاری جدید تحقیقات پیشرفته و فناوری را برای کشاورزان افغان به ارمغان می‌آورد.',
                    'content' => 'موسسه مونت آگرو با مرکز بین‌المللی تحقیقات کشاورزی در مناطق خشک (ایکاردا) وارد مشارکت استراتژیک شده است تا تحقیقات پیشرفته و فناوری را به بخش کشاورزی افغانستان بیاورد.

این مشارکت بر موارد زیر تمرکز خواهد داشت:
- توسعه انواع محصولات مقاوم به خشکسالی
- تکنیک‌های کشاورزی هوشمند اقلیمی
- روش‌های حفاظت از خاک و آب
- ظرفیت‌سازی برای محققان محلی
- انتقال فناوری و پذیرش نوآوری

این همکاری شامل پروژه‌های تحقیقاتی مشترک، تبادلات آموزشی، و تأسیس مزارع نمایشی است که در آن تکنیک‌های جدید می‌توانند برای شرایط محلی آزمایش و اصلاح شوند. این مشارکت گامی مهم در پیشبرد علم و عمل کشاورزی در افغانستان محسوب می‌شود.

پروژه‌های اولیه بر توسعه انواع گندم بهتر سازگار با شرایط اقلیمی در حال تغییر و بهبود کارایی استفاده از آب در سیستم‌های آبیاری تمرکز خواهند داشت. انتظار می‌رود این مشارکت هزاران کشاورز در سراسر کشور را از طریق فناوری‌ها و شیوه‌های کشاورزی بهبود یافته بهره‌مند کند.'
                ],
                'pashto_translations' => [
                    'title' => 'د نړیوال کرنې د څیړنو مرکز سره شریکوالی',
                    'excerpt' => 'نوی همکارۍ د افغان کروندګرو لپاره د پرمختللو څیړنو او ټیکنالوژۍ راوړي.',
                    'content' => 'د مونت اګرو موسسه د وچو سیمو کې د کرنې د څیړنو د نړیوال مرکز (ایکاردا) سره د استراتژیک شریکوالۍ کې ننوتلی ترڅو پرمختللي څیړنې او ټیکنالوژي د افغانستان د کرنې برخې ته راوړي.

دا شریکوالی په لاندې مواردو تمرکز کوي:
- د وچکالۍ مقاومو محصولاتو د ډولونو پراختیا
- د اقلیم هوشمند کرنې تخنیکونه
- د خاورې او اوبو د ساتنې میتودونه
- د محلي څیړونکو لپاره د ظرفیت جوړونه
- د ټیکنالوژۍ لیږد او د نوښت منل

دا همکارۍ مشترک څیړنیز پروژې، د روزنې تبادل، او د مظاهره فارمونو جوړول شاملوي چې پکې نوي تخنیکونه د محلي شرایطو لپاره ازمایښت او اصلاح کیدی شي. دا شریکوالی د افغانستان کې د کرنې د علم او عمل د پرمختګ لپاره یو مهم ګام دی.

لومړني پروژې به د بدلونونو اقلیمي شرایطو سره د ښه سازښت د ګندم د ډولونو پراختیا او د اوبو د کارونې د اغیزمنتیا په ابیاري سیسټمونو کې د ښه والي پر تمرکز وي. تمه کیږي چې دا شریکوالی د هېواد په اوږدو کې د ګڼو زرو کروندګرو ته د ښه شویو کرنې ټیکنالوژیو او دودونو له لارې ګټه ورسوي.'
                ]
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }

        $this->command->info('Featured news articles created successfully!');
    }
}