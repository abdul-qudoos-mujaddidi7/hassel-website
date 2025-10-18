<?php

namespace Database\Seeders;

use App\Models\SuccessStory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SuccessStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $successStories = [
            [
                'title' => 'From Traditional to Modern: Ahmads Agricultural Transformation',
                'client_name' => 'Ahmad Khan',
                'story' => 'Ahmad Khan started with just 2 acres of land and traditional farming methods. Through Mount Agro Institution comprehensive training programs, he learned modern irrigation techniques, sustainable farming practices, and integrated pest management. Within two seasons, his crop yields increased by 40%, and his income doubled. Today, Ahmad employs 5 local farmers and serves as a model for the entire community, inspiring others to adopt modern agricultural practices.',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
                'status' => 'published',
                'published_at' => now()->subMonths(3),
                'farsi_translations' => [
                    'title' => 'از سنتی تا مدرن: تحول کشاورزی احمد',
                    'client_name' => 'احمد خان',
                    'story' => 'احمد خان با تنها 2 جریب زمین و روش‌های کشاورزی سنتی شروع کرد. از طریق برنامه‌های جامع آموزشی موسسه مونت آگرو، او تکنیک‌های آبیاری مدرن، شیوه‌های کشاورزی پایدار و مدیریت یکپارچه آفات را آموخت. در طی دو فصل، محصولاتش 40 درصد افزایش یافت و درآمدش دو برابر شد. امروز احمد 5 کشاورز محلی را استخدام کرده و به عنوان الگویی برای کل جامعه عمل می‌کند و دیگران را به اتخاذ شیوه‌های کشاورزی مدرن تشویق می‌کند.'
                ],
                'pashto_translations' => [
                    'title' => 'د سنتی څخه تر عصري پورې: د احمد کرنيز بدلون',
                    'client_name' => 'احمد خان',
                    'story' => 'احمد خان د یوازې 2 جریبه ځمکې او دودیزو کرنیزو لارو سره پیل وکړ. د مونت آگرو موسسې د بشپړو روزنيزو پروګرامونو له لارې، هغه د عصري اوبو ورکولو تخنیکونه، د پایدار کرنې طریقې او د آفاتو یوځای مدیریت زده کړ. د دوه فصلونو په اوږدو کې، د هغه محصولات 40 سلنه زیات شول او عاید یې دوه برابره شو. نن احمد 5 کليوال کرنګرونه دنده ورکړي دي او د ټولنې لپاره د یوې نمونې په توګه کار کوي او نورو ته د عصري کرنیزو طریقو د پلي کولو هڅونه کوي.'
                ]
            ],
            [
                'title' => 'Greenhouse Revolution: Fatimas Year-Round Success',
                'client_name' => 'Fatima Zahra',
                'story' => 'Fatima Zahra had the vision but lacked the knowledge to implement greenhouse farming. Through our comprehensive training program and ongoing mentorship, she successfully established a modern greenhouse operation. The controlled environment allowed year-round production, increasing her annual income by 300% and providing fresh vegetables to the local market even during harsh weather conditions.',
                'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b47c?auto=format&fit=crop&w=400&q=80',
                'status' => 'published',
                'published_at' => now()->subMonths(2),
                'farsi_translations' => [
                    'title' => 'انقلاب گلخانه‌ای: موفقیت سالانه فاطمه',
                    'client_name' => 'فاطمه زهرا',
                    'story' => 'فاطمه زهرا چشم‌انداز داشت اما دانش پیاده‌سازی کشاورزی گلخانه‌ای را نداشت. از طریق برنامه جامع آموزشی ما و راهنمایی مداوم، او با موفقیت یک عملیات گلخانه‌ای مدرن راه‌اندازی کرد. محیط کنترل شده امکان تولید در تمام طول سال را فراهم کرد و درآمد سالانه‌اش را 300 درصد افزایش داد و سبزیجات تازه را حتی در شرایط آب و هوایی سخت به بازار محلی ارائه می‌دهد.'
                ],
                'pashto_translations' => [
                    'title' => 'د ګلخانې انقلاب: د فاطمې کلنی بریالیتوب',
                    'client_name' => 'فاطمه زهرا',
                    'story' => 'فاطمه زهرا لید درلود مګر د ګلخانې کرنې د پلي کولو پوهه یې نه درلوده. زموږ د بشپړ روزنيز پروګرام او دوامداره مشاورت له لارې، هغه په بریالیتوب سره یو عصري ګلخانې عملیات پیل کړ. کنترول شوی چاپیریال د کل کال تولید امکان ورکړ، د هغې کلنی عاید 300 سلنه زیات کړ او د تازه سبزیجاتو وړاندیز یې حتی د سخته هوا د شرایطو په وخت کې د کلي بازار ته وکړ.'
                ]
            ],
            [
                'title' => 'Water Conservation Champion: Mohammads Sustainable Solution',
                'client_name' => 'Mohammad Hassan',
                'story' => 'Water scarcity was the biggest challenge for Mohammad Hassan farm. Our water management specialists introduced drip irrigation and rainwater harvesting techniques. These innovations reduced water usage by 50% while increasing crop yields. The success inspired neighboring farmers to adopt similar practices, creating a ripple effect throughout the region and establishing Mohammad as a water conservation champion.',
                'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&q=80',
                'status' => 'published',
                'published_at' => now()->subMonths(4),
                'farsi_translations' => [
                    'title' => 'قهرمان صرفه‌جویی آب: راه‌حل پایدار محمد',
                    'client_name' => 'محمد حسن',
                    'story' => 'کمبود آب بزرگترین چالش مزرعه محمد حسن بود. متخصصان مدیریت آب ما تکنیک‌های آبیاری قطره‌ای و جمع‌آوری آب باران را معرفی کردند. این نوآوری‌ها استفاده از آب را 50 درصد کاهش داد در حالی که محصولات افزایش یافت. این موفقیت کشاورزان همسایه را برانگیخت تا شیوه‌های مشابه را اتخاذ کنند و اثر موجی در سراسر منطقه ایجاد کرد و محمد را به عنوان قهرمان صرفه‌جویی آب تثبیت کرد.'
                ],
                'pashto_translations' => [
                    'title' => 'د اوبو د خوندي کولو اتل: د محمد پایدار حل',
                    'client_name' => 'محمد حسن',
                    'story' => 'د اوبو کمښت د محمد حسن د فارم ترټولو لویه ننګونه وه. زموږ د اوبو د مدیریت متخصصینو د ټپو اوبو ورکولو تخنیکونه او د باران د اوبو راټولولو طریقې معرفي کړل. دا نوښتونه د اوبو کارونه 50 سلنه کم کړل په داسې حال کې چې محصولات زیات شول. دا بریالیتوب د ګاونډیو کرنګرانو هڅول چې ورته طریقې وکاروي او د سیمې په ټولو برخو کې د څپو اغیزه رامنځته کړه او محمد د اوبو د خوندي کولو د اتل په توګه تثبیت کړ.'
                ]
            ],
            [
                'title' => 'From Farmer to Entrepreneur: Zahras Business Success',
                'client_name' => 'Zahra Ahmadi',
                'story' => 'Starting as a small-scale farmer, Zahra Ahmadi participated in our business development program. She learned financial management, market analysis, and value-added processing. Today, she runs a successful agro-processing business, creating employment for 15 people and adding value to local agricultural products before selling to urban markets. Her business has become a cornerstone of the local economy.',
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
                'status' => 'published',
                'published_at' => now()->subMonths(1),
                'farsi_translations' => [
                    'title' => 'از کشاورز تا کارآفرین: موفقیت تجاری زهرا',
                    'client_name' => 'زهرا احمدی',
                    'story' => 'زهرا احمدی به عنوان یک کشاورز خرده‌پا شروع کرد و در برنامه توسعه کسب‌وکار ما شرکت کرد. او مدیریت مالی، تحلیل بازار و فرآوری ارزش‌افزوده را آموخت. امروز او یک کسب‌وکار موفق فرآوری کشاورزی را اداره می‌کند که برای 15 نفر اشتغال ایجاد کرده و ارزش به محصولات کشاورزی محلی اضافه می‌کند قبل از فروش به بازارهای شهری. کسب‌وکارش به سنگ بنای اقتصاد محلی تبدیل شده است.'
                ],
                'pashto_translations' => [
                    'title' => 'د کرنګر څخه تر سوداګر پورې: د زهرا سوداګریز بریالیتوب',
                    'client_name' => 'زهرا احمدي',
                    'story' => 'زهرا احمدي د یو کوچني کرنګر په توګه پیل وکړ او زموږ د سوداګریز پراختیا پروګرام کې برخه واخیسته. هغې د مالي مدیریت، د بازار تحلیل او د ارزښت زیاتولو پروسس زده کړ. نن هغه یو بریالی کرنیز پروسس سوداګري چلوي چې 15 کسانو ته دنده ورکړې ده او د کلي د کرنیزو محصولاتو ته ارزښت زیاتوي د ښاري بازارونو ته پلورلو دمخه. د هغې سوداګري د کلي د اقتصاد د بنسټ په توګه بدله شوې ده.'
                ]
            ],
            [
                'title' => 'Organic Pioneer: Abduls Chemical-Free Success',
                'client_name' => 'Abdul Rahman',
                'story' => 'Abdul Rahman was determined to create a chemical-free farming operation. Through our organic farming program, he learned natural pest control methods, composting techniques, and soil health improvement. His organic produce commands premium prices in the market, and his farm has become a model for sustainable agriculture. Abdul now trains other farmers in organic methods, spreading environmental consciousness throughout the community.',
                'image' => 'https://images.unsplash.com/photo-1527980965255-d3b416303d12?auto=format&fit=crop&w=400&q=80',
                'status' => 'published',
                'published_at' => now()->subWeeks(2),
                'farsi_translations' => [
                    'title' => 'پیشگام ارگانیک: موفقیت بدون مواد شیمیایی عبدالرحمن',
                    'client_name' => 'عبدالرحمن',
                    'story' => 'عبدالرحمن مصمم بود تا یک عملیات کشاورزی بدون مواد شیمیایی ایجاد کند. از طریق برنامه کشاورزی ارگانیک ما، او روش‌های کنترل طبیعی آفات، تکنیک‌های کمپوست و بهبود سلامت خاک را آموخت. محصولات ارگانیک او قیمت‌های بالایی در بازار دارد و مزرعه‌اش به الگویی برای کشاورزی پایدار تبدیل شده است. عبدالرحمن اکنون کشاورزان دیگر را در روش‌های ارگانیک آموزش می‌دهد و آگاهی محیط‌زیستی را در سراسر جامعه گسترش می‌دهد.'
                ],
                'pashto_translations' => [
                    'title' => 'د عضوي مخکښ: د عبدالرحمن د کیمیاوي موادو پرته بریالیتوب',
                    'client_name' => 'عبدالرحمن',
                    'story' => 'عبدالرحمن د کیمیاوي موادو پرته د کرنې عملیات رامنځته کولو ته ټاکلی و. زموږ د عضوي کرنې پروګرام له لارې، هغه د طبیعي آفاتو د کنترول طریقې، د کمپوسټ تخنیکونه او د خاورې د روغتیا ښه والی زده کړ. د هغه عضوي محصولات په بازار کې لوړې قیمتونه لري او د هغه فارم د پایدار کرنې لپاره د یوې نمونې په توګه بدل شوی دی. عبدالرحمن اوس نور کرنګرونه د عضوي طریقو په اړه روزي او د چاپیریال پوهه د ټولنې په ټولو برخو کې خپروي.'
                ]
            ],
            [
                'title' => 'Technology Integration: Mariams Smart Farming Journey',
                'client_name' => 'Mariam Safi',
                'story' => 'Mariam Safi embraced technology to revolutionize her farming practices. Through our smart farming program, she learned to use mobile apps for crop monitoring, weather tracking, and market price analysis. She also implemented automated irrigation systems and soil sensors. The integration of technology increased her efficiency by 60% and reduced costs significantly, making her farm one of the most productive in the region.',
                'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=400&q=80',
                'status' => 'published',
                'published_at' => now()->subWeeks(3),
                'farsi_translations' => [
                    'title' => 'یکپارچه‌سازی فناوری: سفر کشاورزی هوشمند مریم',
                    'client_name' => 'مریم صافی',
                    'story' => 'مریم صافی فناوری را پذیرفت تا شیوه‌های کشاورزی خود را متحول کند. از طریق برنامه کشاورزی هوشمند ما، او یاد گرفت از اپلیکیشن‌های موبایل برای نظارت بر محصولات، ردیابی آب و هوا و تحلیل قیمت‌های بازار استفاده کند. او همچنین سیستم‌های آبیاری خودکار و حسگرهای خاک را پیاده‌سازی کرد. یکپارچه‌سازی فناوری کارایی او را 60 درصد افزایش داد و هزینه‌ها را به طور قابل توجهی کاهش داد و مزرعه‌اش را به یکی از پربازده‌ترین مزرعه‌های منطقه تبدیل کرد.'
                ],
                'pashto_translations' => [
                    'title' => 'د ټیکنالوژۍ یوځای کول: د مریم د هوشمند کرنې سفر',
                    'client_name' => 'مریم صافي',
                    'story' => 'مریم صافي ټیکنالوژي ومنله ترڅو د خپلو کرنیزو طریقو انقلاب راوستل شي. زموږ د هوشمند کرنې پروګرام له لارې، هغې زده کړل چې د موبایل غوښتنلیکونه د محصولاتو د څارنې، د هوا د تعقیب او د بازار د قیمتونو د تحلیل لپاره وکاروي. هغې همدارنګه د خپلکار اوبو ورکولو سیسټمونه او د خاورې سینسرونه پلي کړل. د ټیکنالوژۍ یوځای کول د هغې کارایی 60 سلنه زیاته کړه او لګښتونه په پام وړ توګه کم کړل او د هغې فارم د سیمې د ترټولو ګټورو فارمونو څخه یو کړ.'
                ]
            ],
            [
                'title' => 'Community Leader: Hajis Cooperative Success',
                'client_name' => 'Haji Mohammad',
                'story' => 'Haji Mohammad recognized the power of collective action and established a farmers cooperative in his village. Through our community development program, he learned leadership skills, cooperative management, and collective marketing strategies. The cooperative now includes 25 farmers, has access to better credit facilities, and negotiates better prices for their products. Hajis leadership has transformed the economic landscape of his entire village.',
                'image' => 'https://images.unsplash.com/photo-1463453091185-61582044d556?auto=format&fit=crop&w=400&q=80',
                'status' => 'published',
                'published_at' => now()->subMonths(5),
                'farsi_translations' => [
                    'title' => 'رهبر جامعه: موفقیت تعاونی حاجی',
                    'client_name' => 'حاجی محمد',
                    'story' => 'حاجی محمد قدرت عمل جمعی را شناخت و یک تعاونی کشاورزان در روستای خود تأسیس کرد. از طریق برنامه توسعه جامعه ما، او مهارت‌های رهبری، مدیریت تعاونی و استراتژی‌های بازاریابی جمعی را آموخت. تعاونی اکنون شامل 25 کشاورز است، به تسهیلات اعتباری بهتر دسترسی دارد و قیمت‌های بهتری برای محصولات خود مذاکره می‌کند. رهبری حاجی چشمانداز اقتصادی کل روستای خود را متحول کرده است.'
                ],
                'pashto_translations' => [
                    'title' => 'د ټولنې مشر: د حاجي د تعاوني بریالیتوب',
                    'client_name' => 'حاجي محمد',
                    'story' => 'حاجي محمد د ګډو اقداماتو واک وپیژند او د خپل کلي کې د کرنګرانو تعاوني جوړه کړه. زموږ د ټولنيز پراختیا پروګرام له لارې، هغه د مشرتابه مهارتونه، د تعاوني مدیریت او د ګډو بازارموندنې استراتژۍ زده کړل. تعاوني اوس 25 کرنګرونه لري، د غوره کریډیټ تسهیلاتو ته لاسرسی لري او د خپلو محصولاتو لپاره غوره قیمتونه خبرې کوي. د حاجي مشرتابه د هغه د ټول کلي اقتصادي چاپیریال بدل کړی دی.'
                ]
            ],
            [
                'title' => 'Women Empowerment: Aishas Agricultural Leadership',
                'client_name' => 'Aisha Bibi',
                'story' => 'Aisha Bibi broke traditional barriers to become a successful agricultural entrepreneur. Through our women empowerment program, she gained business skills, technical knowledge, and confidence to lead her own farming operation. She now manages 10 acres of land, employs 8 women from her community, and serves as an inspiration for other women to pursue agricultural careers. Aishas success has challenged gender norms and opened new opportunities for women in agriculture.',
                'image' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=400&q=80',
                'status' => 'published',
                'published_at' => now()->subWeeks(4),
                'farsi_translations' => [
                    'title' => 'توانمندسازی زنان: رهبری کشاورزی عایشه',
                    'client_name' => 'عایشه بی بی',
                    'story' => 'عایشه بی بی موانع سنتی را شکست تا به یک کارآفرین موفق کشاورزی تبدیل شود. از طریق برنامه توانمندسازی زنان ما، او مهارت‌های تجاری، دانش فنی و اعتماد به نفس برای رهبری عملیات کشاورزی خود را به دست آورد. او اکنون 10 جریب زمین را مدیریت می‌کند، 8 زن از جامعه خود را استخدام کرده و به عنوان الهام‌بخش زنان دیگر برای دنبال کردن مشاغل کشاورزی عمل می‌کند. موفقیت عایشه هنجارهای جنسیتی را به چالش کشیده و فرصت‌های جدیدی برای زنان در کشاورزی باز کرده است.'
                ],
                'pashto_translations' => [
                    'title' => 'د ښځو واک ورکول: د عایشې د کرنې مشرتابه',
                    'client_name' => 'عایشه بي بي',
                    'story' => 'عایشه بي بي دودیز موانع مات کړل ترڅو د یو بریالي کرنیز سوداګر وګرځي. زموږ د ښځو د واک ورکولو پروګرام له لارې، هغې د سوداګرۍ مهارتونه، فني پوهه او د خپلو کرنیزو عملیاتو د مشرتابه لپاره باور ترلاسه کړ. هغه اوس 10 جریبه ځمکه اداره کوي، د خپلې ټولنې 8 ښځې دنده ورکړې دي او د نورو ښځو لپاره د کرنیزو مسلکونو د تعقیب لپاره د یوې الهام ورکوونکې په توګه کار کوي. د عایشې بریالیتوب د جنسي هنجارونو ننګونه کړې ده او د ښځو لپاره په کرنه کې نوي فرصتونه پرانیستي دي.'
                ]
            ]
        ];

        foreach ($successStories as $storyData) {
            $successStory = SuccessStory::create([
                'title' => $storyData['title'],
                'slug' => Str::slug($storyData['title']),
                'client_name' => $storyData['client_name'],
                'story' => $storyData['story'],
                'image' => $storyData['image'],
                'status' => $storyData['status'],
                'published_at' => $storyData['published_at'],
                'farsi_translations' => $storyData['farsi_translations'],
                'pashto_translations' => $storyData['pashto_translations'],
            ]);

            // Create individual translation records for better querying
            $this->createTranslationRecords($successStory, $storyData);
        }
    }

    /**
     * Create individual translation records for better database querying
     */
    private function createTranslationRecords(SuccessStory $successStory, array $storyData): void
    {
        // Create Farsi translations
        foreach ($storyData['farsi_translations'] as $field => $value) {
            $successStory->translations()->create([
                'field_name' => $field,
                'content' => $value,
                'language' => 'farsi',
            ]);
        }

        // Create Pashto translations
        foreach ($storyData['pashto_translations'] as $field => $value) {
            $successStory->translations()->create([
                'field_name' => $field,
                'content' => $value,
                'language' => 'pashto',
            ]);
        }
    }
}
