<?php

namespace Database\Seeders;

use App\Models\Publication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publications = [
            [
                'title' => 'Annual Agricultural Development Report 2024',
                'description' => 'Comprehensive analysis of agricultural development initiatives, crop yields, and rural community impact across Afghanistan. This report covers the latest trends in sustainable farming, technology adoption, and economic outcomes for farming communities.',
                'file_type' => 'report',
                'status' => 'published',
                'published_at' => now()->subMonths(2),
                'farsi_translations' => [
                    'title' => 'گزارش سالانه توسعه کشاورزی 2024',
                    'description' => 'تحلیل جامع از ابتکارات توسعه کشاورزی، عملکرد محصولات و تأثیر بر جوامع روستایی در سراسر افغانستان. این گزارش شامل آخرین روندها در کشاورزی پایدار، پذیرش فناوری و نتایج اقتصادی برای جوامع کشاورزی است.'
                ],
                'pashto_translations' => [
                    'title' => 'د 2024 کال د کرنې د پراختیا کلنی راپور',
                    'description' => 'د افغانستان په ټولو برخو کې د کرنیزو پراختیايي نوښتونو، د محصولاتو د تولیداتو او د کلیو د ټولنو د اغیزو بشپړ تحلیل. دا راپور د پایدار کرنې، د ټیکنالوژۍ د پلي کولو او د کرنیزو ټولنو د اقتصادي پایلو په اړه د وروستيو روندونو پوښي.'
                ]
            ],
            [
                'title' => 'Sustainable Farming Practices Manual',
                'description' => 'A comprehensive guide to sustainable agricultural practices including soil conservation, water management, organic farming techniques, and integrated pest management. This manual provides step-by-step instructions for farmers to adopt environmentally friendly farming methods.',
                'file_type' => 'manual',
                'status' => 'published',
                'published_at' => now()->subMonths(3),
                'farsi_translations' => [
                    'title' => 'راهنمای شیوه‌های کشاورزی پایدار',
                    'description' => 'راهنمای جامع شیوه‌های کشاورزی پایدار شامل حفاظت از خاک، مدیریت آب، تکنیک‌های کشاورزی ارگانیک و مدیریت یکپارچه آفات. این راهنما دستورالعمل‌های گام به گام برای کشاورزان ارائه می‌دهد تا روش‌های کشاورزی دوستدار محیط زیست را اتخاذ کنند.'
                ],
                'pashto_translations' => [
                    'title' => 'د پایدار کرنې د طریقو لارښود',
                    'description' => 'د پایدار کرنیزو طریقو بشپړ لارښود چې د خاورې ساتنه، د اوبو مدیریت، عضوي کرنیز تخنیکونه او د آفاتو یوځای مدیریت پکې شامل دي. دا لارښود د کرنګرانو لپاره د ګام په ګام لارښوونو وړاندیز کوي ترڅو د چاپیریال ساتونکو کرنیزو طریقو ته مخه کړي.'
                ]
            ],
            [
                'title' => 'Water Management Best Practices Guide',
                'description' => 'Essential guidelines for efficient water use in agriculture, covering irrigation techniques, rainwater harvesting, water conservation methods, and drought-resistant farming practices. This guide helps farmers optimize water resources for maximum crop yield.',
                'file_type' => 'guideline',
                'status' => 'published',
                'published_at' => now()->subMonths(1),
                'farsi_translations' => [
                    'title' => 'راهنمای بهترین شیوه‌های مدیریت آب',
                    'description' => 'راهنمای ضروری برای استفاده کارآمد از آب در کشاورزی، شامل تکنیک‌های آبیاری، جمع‌آوری آب باران، روش‌های صرفه‌جویی آب و شیوه‌های کشاورزی مقاوم به خشکسالی. این راهنما به کشاورزان کمک می‌کند تا منابع آبی را برای حداکثر عملکرد محصول بهینه‌سازی کنند.'
                ],
                'pashto_translations' => [
                    'title' => 'د اوبو د مدیریت د غوره طریقو لارښود',
                    'description' => 'د کرنه کې د اوبو د اغیزمن کارونې لپاره اړین لارښودونه چې د اوبو ورکولو تخنیکونه، د باران د اوبو راټولول، د اوبو د خوندي کولو طریقې او د وچکالۍ سره مقاوم کرنیز طریقې پکې شامل دي. دا لارښود د کرنګرانو سره مرسته کوي ترڅو د اوبو سرچینې د ترټولو زیات محصول د تولید لپاره غوره کړي.'
                ]
            ],
            [
                'title' => 'Crop Protection Guidelines',
                'description' => 'Comprehensive guidelines for protecting crops from pests, diseases, and environmental stresses. Includes information on integrated pest management, biological control methods, and safe use of pesticides while maintaining environmental sustainability.',
                'file_type' => 'guideline',
                'status' => 'published',
                'published_at' => now()->subWeeks(2),
                'farsi_translations' => [
                    'title' => 'راهنمای حفاظت از محصولات',
                    'description' => 'راهنمای جامع برای حفاظت محصولات از آفات، بیماری‌ها و تنش‌های محیطی. شامل اطلاعات در مورد مدیریت یکپارچه آفات، روش‌های کنترل بیولوژیکی و استفاده ایمن از آفت‌کش‌ها در حالی که پایداری محیطی حفظ می‌شود.'
                ],
                'pashto_translations' => [
                    'title' => 'د محصولاتو د ساتنې لارښودونه',
                    'description' => 'د محصولاتو د آفاتو، ناروغیو او د چاپیریال د فشارونو څخه د ساتنې لپاره بشپړ لارښودونه. د آفاتو د یوځای مدیریت، د بیولوژیکي کنترول طریقو او د آفت وژونکو د خوندي کارونې په اړه معلومات پکې شامل دي په داسې حال کې چې د چاپیریال پایداري ساتل کیږي.'
                ]
            ],
            [
                'title' => 'Post-Harvest Handling Manual',
                'description' => 'Essential manual for proper post-harvest handling of agricultural products including storage techniques, processing methods, packaging standards, and quality control measures to minimize losses and maximize market value.',
                'file_type' => 'manual',
                'status' => 'published',
                'published_at' => now()->subWeeks(4),
                'farsi_translations' => [
                    'title' => 'راهنمای مدیریت پس از برداشت',
                    'description' => 'راهنمای ضروری برای مدیریت صحیح پس از برداشت محصولات کشاورزی شامل تکنیک‌های ذخیره‌سازی، روش‌های فرآوری، استانداردهای بسته‌بندی و اقدامات کنترل کیفیت برای کاهش تلفات و حداکثرسازی ارزش بازار.'
                ],
                'pashto_translations' => [
                    'title' => 'د وروسته د راټولو د مدیریت لارښود',
                    'description' => 'د کرنیزو محصولاتو د سم وروسته د راټولو د مدیریت لپاره اړین لارښود چې د ذخیره کولو تخنیکونه، د پروسس طریقې، د بسته‌بندۍ معیارونه او د کیفیت د کنترول اقدامات پکې شامل دي ترڅو تلفات کم کړي او د بازار ارزښت زیات کړي.'
                ]
            ],
            [
                'title' => 'Climate-Smart Agriculture Guide',
                'description' => 'Comprehensive guide to climate-smart agricultural practices that help farmers adapt to changing climate conditions while reducing greenhouse gas emissions and increasing productivity and resilience.',
                'file_type' => 'guideline',
                'status' => 'published',
                'published_at' => now()->subMonths(4),
                'farsi_translations' => [
                    'title' => 'راهنمای کشاورزی هوشمند اقلیمی',
                    'description' => 'راهنمای جامع شیوه‌های کشاورزی هوشمند اقلیمی که به کشاورزان کمک می‌کند تا با شرایط اقلیمی در حال تغییر سازگار شوند در حالی که انتشار گازهای گلخانه‌ای را کاهش داده و بهره‌وری و مقاومت را افزایش می‌دهند.'
                ],
                'pashto_translations' => [
                    'title' => 'د اقلیم هوشمند کرنې لارښود',
                    'description' => 'د اقلیم هوشمند کرنیزو طریقو بشپړ لارښود چې د کرنګرانو سره مرسته کوي ترڅو د بدلون کوونکو اقلیمي شرایطو سره سازګار شي په داسې حال کې چې د ګلخانې ګازونو خپرونه کم کړي او د تولیداتو او مقاومت زیاتوالی راوستي.'
                ]
            ],
            [
                'title' => 'Organic Farming Techniques Guide',
                'description' => 'Detailed guide to organic farming methods including soil preparation, natural pest control, composting techniques, crop rotation, and certification processes for organic agriculture.',
                'file_type' => 'manual',
                'status' => 'published',
                'published_at' => now()->subMonths(5),
                'farsi_translations' => [
                    'title' => 'راهنمای تکنیک‌های کشاورزی ارگانیک',
                    'description' => 'راهنمای تفصیلی روش‌های کشاورزی ارگانیک شامل آماده‌سازی خاک، کنترل طبیعی آفات، تکنیک‌های کمپوست، تناوب زراعی و فرآیندهای گواهی برای کشاورزی ارگانیک.'
                ],
                'pashto_translations' => [
                    'title' => 'د عضوي کرنې د تخنیکونو لارښود',
                    'description' => 'د عضوي کرنیزو طریقو تفصيلي لارښود چې د خاورې تیاري، د طبیعي آفاتو کنترول، د کمپوسټ تخنیکونه، د محصولاتو بدلون او د عضوي کرنې لپاره د تصدیق پروسونه پکې شامل دي.'
                ]
            ],
            [
                'title' => 'Rural Community Impact Assessment 2024',
                'description' => 'Comprehensive assessment of Mount Agro Institution programs impact on rural communities, including economic benefits, social development, environmental improvements, and community empowerment outcomes.',
                'file_type' => 'report',
                'status' => 'published',
                'published_at' => now()->subWeeks(6),
                'farsi_translations' => [
                    'title' => 'ارزیابی تأثیر جامعه روستایی 2024',
                    'description' => 'ارزیابی جامع تأثیر برنامه‌های موسسه مونت آگرو بر جوامع روستایی، شامل منافع اقتصادی، توسعه اجتماعی، بهبودهای محیطی و نتایج توانمندسازی جامعه.'
                ],
                'pashto_translations' => [
                    'title' => 'د 2024 کال د کلیو د ټولنو د اغیزو ارزونه',
                    'description' => 'د مونت آگرو موسسې د پروګرامونو د کلیو د ټولنو پر اغیزو بشپړ ارزونه چې اقتصادي ګټې، ټولنيزه پراختیا، د چاپیریال ښه والي او د ټولنې د واک ورکولو پایلې پکې شامل دي.'
                ]
            ],
            [
                'title' => 'Irrigation Systems Effectiveness Study',
                'description' => 'Detailed study analyzing the effectiveness of various irrigation systems implemented across different regions, including drip irrigation, sprinkler systems, and traditional methods, with recommendations for optimal water usage.',
                'file_type' => 'report',
                'status' => 'published',
                'published_at' => now()->subMonths(6),
                'farsi_translations' => [
                    'title' => 'مطالعه اثربخشی سیستم‌های آبیاری',
                    'description' => 'مطالعه تفصیلی تحلیل اثربخشی سیستم‌های مختلف آبیاری پیاده‌سازی شده در مناطق مختلف، شامل آبیاری قطره‌ای، سیستم‌های آبپاش و روش‌های سنتی، با توصیه‌هایی برای استفاده بهینه از آب.'
                ],
                'pashto_translations' => [
                    'title' => 'د اوبو ورکولو د سیسټمونو د اغیزمنتوب مطالعه',
                    'description' => 'د مختلفو سیمو کې پلي شوي د مختلفو اوبو ورکولو د سیسټمونو د اغیزمنتوب تفصيلي مطالعه چې د ټپو اوبو ورکول، د اوبو د پاشولو سیسټمونه او دودیز طریقې پکې شامل دي، د اوبو د غوره کارونې لپاره د وړاندیزونو سره.'
                ]
            ],
            [
                'title' => 'Food Security Status Report',
                'description' => 'Annual report on food security status across Afghanistan, analyzing production levels, distribution challenges, nutritional outcomes, and recommendations for improving food security in rural and urban areas.',
                'file_type' => 'report',
                'status' => 'published',
                'published_at' => now()->subMonths(7),
                'farsi_translations' => [
                    'title' => 'گزارش وضعیت امنیت غذایی',
                    'description' => 'گزارش سالانه وضعیت امنیت غذایی در سراسر افغانستان، تحلیل سطوح تولید، چالش‌های توزیع، نتایج تغذیه‌ای و توصیه‌هایی برای بهبود امنیت غذایی در مناطق روستایی و شهری.'
                ],
                'pashto_translations' => [
                    'title' => 'د خوړو د امنیت د وضعیت راپور',
                    'description' => 'د افغانستان په ټولو برخو کې د خوړو د امنیت د وضعیت کلنی راپور چې د تولید کچې، د ویشلو ننګونې، د تغذیې پایلې او د کلیو او ښاري سیمو کې د خوړو د امنیت د ښه کولو لپاره وړاندیزونه تحلیل کوي.'
                ]
            ],
            [
                'title' => 'Environmental Protection Guidelines',
                'description' => 'Comprehensive guidelines for environmental protection in agricultural activities, covering soil conservation, water quality protection, biodiversity preservation, and sustainable resource management practices.',
                'file_type' => 'guideline',
                'status' => 'published',
                'published_at' => now()->subMonths(8),
                'farsi_translations' => [
                    'title' => 'راهنمای حفاظت از محیط زیست',
                    'description' => 'راهنمای جامع حفاظت از محیط زیست در فعالیت‌های کشاورزی، شامل حفاظت از خاک، حفاظت از کیفیت آب، حفظ تنوع زیستی و شیوه‌های مدیریت پایدار منابع.'
                ],
                'pashto_translations' => [
                    'title' => 'د چاپیریال د ساتنې لارښودونه',
                    'description' => 'د کرنیزو فعالیتونو کې د چاپیریال د ساتنې لپاره بشپړ لارښودونه چې د خاورې ساتنه، د اوبو د کیفیت ساتنه، د بیولوژیکي تنوع ساتنه او د پایدارو سرچینو د مدیریت طریقې پکې شامل دي.'
                ]
            ],
            [
                'title' => 'Integrated Pest Management Protocol',
                'description' => 'Detailed protocol for integrated pest management combining biological, cultural, physical, and chemical control methods to effectively manage pests while minimizing environmental impact and ensuring crop safety.',
                'file_type' => 'guideline',
                'status' => 'published',
                'published_at' => now()->subMonths(9),
                'farsi_translations' => [
                    'title' => 'پروتکل مدیریت یکپارچه آفات',
                    'description' => 'پروتکل تفصیلی مدیریت یکپارچه آفات که روش‌های کنترل بیولوژیکی، فرهنگی، فیزیکی و شیمیایی را ترکیب می‌کند تا آفات را به طور مؤثر مدیریت کند در حالی که تأثیر محیطی را به حداقل رسانده و ایمنی محصولات را تضمین می‌کند.'
                ],
                'pashto_translations' => [
                    'title' => 'د آفاتو د یوځای مدیریت پروتوکول',
                    'description' => 'د آفاتو د یوځای مدیریت تفصيلي پروتوکول چې د بیولوژیکي، کلتوري، فزیکي او کیمیاوي کنترول طریقې یوځای کوي ترڅو آفات په اغیزمنه توګه اداره کړي په داسې حال کې چې د چاپیریال اغیز کم کړي او د محصولاتو امنیت تضمین کړي.'
                ]
            ],
            [
                'title' => 'Soil Conservation Guidelines',
                'description' => 'Essential guidelines for soil conservation and improvement including erosion control, soil testing, nutrient management, and sustainable soil practices to maintain long-term agricultural productivity.',
                'file_type' => 'guideline',
                'status' => 'published',
                'published_at' => now()->subMonths(10),
                'farsi_translations' => [
                    'title' => 'راهنمای حفاظت از خاک',
                    'description' => 'راهنمای ضروری حفاظت و بهبود خاک شامل کنترل فرسایش، آزمایش خاک، مدیریت مواد مغذی و شیوه‌های پایدار خاک برای حفظ بهره‌وری کشاورزی درازمدت.'
                ],
                'pashto_translations' => [
                    'title' => 'د خاورې د ساتنې لارښودونه',
                    'description' => 'د خاورې د ساتنې او ښه کولو لپاره اړین لارښودونه چې د فرسایش کنترول، د خاورې ازموینه، د مغذي موادو مدیریت او د پایدارو خاورې طریقې پکې شامل دي ترڅو د اوږد مهاله کرنیز تولیدات ساتل شي.'
                ]
            ],
            [
                'title' => 'Agricultural Technology Adoption Report',
                'description' => 'Comprehensive report on the adoption of agricultural technologies across different regions, analyzing factors affecting technology uptake, success stories, challenges, and recommendations for increasing technology adoption rates.',
                'file_type' => 'report',
                'status' => 'published',
                'published_at' => now()->subMonths(11),
                'farsi_translations' => [
                    'title' => 'گزارش پذیرش فناوری کشاورزی',
                    'description' => 'گزارش جامع پذیرش فناوری‌های کشاورزی در مناطق مختلف، تحلیل عوامل مؤثر بر پذیرش فناوری، داستان‌های موفقیت، چالش‌ها و توصیه‌هایی برای افزایش نرخ پذیرش فناوری.'
                ],
                'pashto_translations' => [
                    'title' => 'د کرنیزې ټیکنالوژۍ د پلي کولو راپور',
                    'description' => 'د مختلفو سیمو کې د کرنیزو ټیکنالوژیو د پلي کولو بشپړ راپور چې د ټیکنالوژۍ د پلي کولو اغیزمن عوامل، د بریالیتوب کیسې، ننګونې او د ټیکنالوژۍ د پلي کولو د کچو د زیاتولو لپاره وړاندیزونه تحلیل کوي.'
                ]
            ],
            [
                'title' => 'Women in Agriculture Empowerment Guide',
                'description' => 'Comprehensive guide for empowering women in agriculture, covering training programs, leadership development, access to resources, and strategies for overcoming gender barriers in agricultural communities.',
                'file_type' => 'manual',
                'status' => 'published',
                'published_at' => now()->subMonths(12),
                'farsi_translations' => [
                    'title' => 'راهنمای توانمندسازی زنان در کشاورزی',
                    'description' => 'راهنمای جامع توانمندسازی زنان در کشاورزی، شامل برنامه‌های آموزشی، توسعه رهبری، دسترسی به منابع و استراتژی‌هایی برای غلبه بر موانع جنسیتی در جوامع کشاورزی.'
                ],
                'pashto_translations' => [
                    'title' => 'د کرنه کې د ښځو د واک ورکولو لارښود',
                    'description' => 'د کرنه کې د ښځو د واک ورکولو لپاره بشپړ لارښود چې روزنيز پروګرامونه، د مشرتابه پراختیا، د سرچینو لاسرسی او د کرنیزو ټولنو کې د جنسي موانعو د ماتولو استراتژۍ پکې شامل دي.'
                ]
            ],
            [
                'title' => 'Market Access and Value Chain Analysis',
                'description' => 'Detailed analysis of agricultural value chains and market access opportunities for smallholder farmers, including market linkages, pricing strategies, and recommendations for improving market participation.',
                'file_type' => 'report',
                'status' => 'published',
                'published_at' => now()->subMonths(13),
                'farsi_translations' => [
                    'title' => 'تحلیل دسترسی به بازار و زنجیره ارزش',
                    'description' => 'تحلیل تفصیلی زنجیره‌های ارزش کشاورزی و فرصت‌های دسترسی به بازار برای کشاورزان خرده‌پا، شامل پیوندهای بازار، استراتژی‌های قیمت‌گذاری و توصیه‌هایی برای بهبود مشارکت در بازار.'
                ],
                'pashto_translations' => [
                    'title' => 'د بازار لاسرسی او د ارزښت د زنځیر تحلیل',
                    'description' => 'د کرنیزو ارزښت زنځیرونو او د کوچنيو کرنګرانو لپاره د بازار د لاسرسی فرصتونو تفصيلي تحلیل چې د بازار اړیکې، د قیمت کولو استراتژۍ او د بازار کې د برخه‌اخیستنې د ښه کولو لپاره وړاندیزونه پکې شامل دي.'
                ]
            ],
            [
                'title' => 'Youth Engagement in Agriculture Program',
                'description' => 'Comprehensive program guide for engaging youth in agricultural activities, including training modules, mentorship programs, innovation challenges, and career development opportunities in the agricultural sector.',
                'file_type' => 'manual',
                'status' => 'published',
                'published_at' => now()->subMonths(14),
                'farsi_translations' => [
                    'title' => 'برنامه مشارکت جوانان در کشاورزی',
                    'description' => 'راهنمای جامع برنامه مشارکت جوانان در فعالیت‌های کشاورزی، شامل ماژول‌های آموزشی، برنامه‌های راهنمایی، چالش‌های نوآوری و فرصت‌های توسعه شغلی در بخش کشاورزی.'
                ],
                'pashto_translations' => [
                    'title' => 'د کرنه کې د ځوانانو د ښکیلتیا پروګرام',
                    'description' => 'د کرنیزو فعالیتونو کې د ځوانانو د ښکیلتیا لپاره بشپړ پروګرام لارښود چې روزنيز ماژولونه، د مشاورت پروګرامونه، د نوښت ننګونې او د کرنیز برخه کې د مسلکي پراختیا فرصتونه پکې شامل دي.'
                ]
            ],
            [
                'title' => 'Agricultural Finance and Credit Access Guide',
                'description' => 'Essential guide for farmers to access agricultural finance and credit facilities, covering loan applications, financial planning, investment strategies, and risk management for agricultural enterprises.',
                'file_type' => 'manual',
                'status' => 'published',
                'published_at' => now()->subMonths(15),
                'farsi_translations' => [
                    'title' => 'راهنمای مالیات کشاورزی و دسترسی به اعتبار',
                    'description' => 'راهنمای ضروری کشاورزان برای دسترسی به تسهیلات مالی و اعتباری کشاورزی، شامل درخواست‌های وام، برنامه‌ریزی مالی، استراتژی‌های سرمایه‌گذاری و مدیریت ریسک برای بنگاه‌های کشاورزی.'
                ],
                'pashto_translations' => [
                    'title' => 'د کرنیزې مالي تمویل او د کریډیټ لاسرسی لارښود',
                    'description' => 'د کرنګرانو لپاره د کرنیزو مالي تمویل او کریډیټ تسهیلاتو ته د لاسرسی لپاره اړین لارښود چې د پور غوښتنلیکونه، مالي پلان جوړونه، د پانګونې استراتژۍ او د کرنیزو بنسټونو لپاره د خطر د مدیریت پکې شامل دي.'
                ]
            ],
            [
                'title' => 'Draft: Advanced Greenhouse Management Techniques',
                'description' => 'Comprehensive guide to advanced greenhouse management including climate control, automation systems, crop optimization, and year-round production strategies. This document is currently under review and will be published soon.',
                'file_type' => 'manual',
                'status' => 'draft',
                'published_at' => null,
                'farsi_translations' => [
                    'title' => 'پیش‌نویس: تکنیک‌های پیشرفته مدیریت گلخانه',
                    'description' => 'راهنمای جامع مدیریت پیشرفته گلخانه شامل کنترل اقلیم، سیستم‌های خودکار، بهینه‌سازی محصولات و استراتژی‌های تولید در تمام طول سال. این سند در حال بررسی است و به زودی منتشر خواهد شد.'
                ],
                'pashto_translations' => [
                    'title' => 'مسوده: د ګلخانې د پرمختللو مدیریت تخنیکونه',
                    'description' => 'د ګلخانې د پرمختللو مدیریت بشپړ لارښود چې د اقلیم کنترول، د خپلکار سیسټمونه، د محصولاتو غوره کول او د کل کال د تولید استراتژۍ پکې شامل دي. دا سند اوس د بیاکتنې لاندې دی او ژر به خپور شي.'
                ]
            ],
            [
                'title' => 'Draft: Digital Agriculture Implementation Strategy',
                'description' => 'Strategic document outlining the implementation of digital agriculture technologies including IoT sensors, data analytics, precision farming, and smart irrigation systems for modern agricultural practices.',
                'file_type' => 'policy',
                'status' => 'draft',
                'published_at' => null,
                'farsi_translations' => [
                    'title' => 'پیش‌نویس: استراتژی پیاده‌سازی کشاورزی دیجیتال',
                    'description' => 'سند استراتژیک که پیاده‌سازی فناوری‌های کشاورزی دیجیتال را ترسیم می‌کند شامل حسگرهای اینترنت اشیاء، تحلیل داده‌ها، کشاورزی دقیق و سیستم‌های آبیاری هوشمند برای شیوه‌های کشاورزی مدرن.'
                ],
                'pashto_translations' => [
                    'title' => 'مسوده: د ډیجیټل کرنې د پلي کولو استراتژي',
                    'description' => 'استراتژیکي سند چې د ډیجیټل کرنیزو ټیکنالوژیو د پلي کولو طرح کوي چې د انټرنیټ شیانو سینسرونه، د ډیټا تحلیل، دقیقه کرنه او د هوشمند اوبو ورکولو سیسټمونه د عصري کرنیزو طریقو لپاره پکې شامل دي.'
                ]
            ],
            [
                'title' => 'Draft: Sustainable Livestock Management Guide',
                'description' => 'Comprehensive guide for sustainable livestock management practices including animal health, nutrition, breeding programs, and environmental considerations for livestock farming operations.',
                'file_type' => 'manual',
                'status' => 'draft',
                'published_at' => null,
                'farsi_translations' => [
                    'title' => 'پیش‌نویس: راهنمای مدیریت پایدار دام',
                    'description' => 'راهنمای جامع شیوه‌های مدیریت پایدار دام شامل سلامت حیوانات، تغذیه، برنامه‌های پرورش و ملاحظات محیطی برای عملیات پرورش دام.'
                ],
                'pashto_translations' => [
                    'title' => 'مسوده: د پایدارو څارویو د مدیریت لارښود',
                    'description' => 'د پایدارو څارویو د مدیریت طریقو بشپړ لارښود چې د حیواناتو روغتیا، تغذیه، د روزنې پروګرامونه او د څارویو د روزنې عملیاتو لپاره د چاپیریال پاملرنې پکې شامل دي.'
                ]
            ]
        ];

        foreach ($publications as $publicationData) {
            $publication = Publication::create([
                'title' => $publicationData['title'],
                'slug' => Str::slug($publicationData['title']),
                'description' => $publicationData['description'],
                'file_path' => $this->generateFilePath($publicationData['file_type']),
                'file_type' => $publicationData['file_type'],
                'status' => $publicationData['status'],
                'published_at' => $publicationData['published_at'],
                'farsi_translations' => $publicationData['farsi_translations'],
                'pashto_translations' => $publicationData['pashto_translations'],
            ]);

            // Create individual translation records for better querying
            $this->createTranslationRecords($publication, $publicationData);
        }

        $this->command->info('✅ Created ' . count($publications) . ' publications with translations');
    }

    /**
     * Generate realistic file path
     */
    private function generateFilePath(string $type): string
    {
        $filename = Str::slug($type) . '_' . time() . '_' . Str::random(8) . '.pdf';
        return "publications/{$type}s/" . date('Y/m') . "/{$filename}";
    }

    /**
     * Create individual translation records for better database querying
     */
    private function createTranslationRecords(Publication $publication, array $publicationData): void
    {
        // Create Farsi translations
        foreach ($publicationData['farsi_translations'] as $field => $value) {
            $publication->translations()->create([
                'field_name' => $field,
                'content' => $value,
                'language' => 'farsi',
            ]);
        }

        // Create Pashto translations
        foreach ($publicationData['pashto_translations'] as $field => $value) {
            $publication->translations()->create([
                'field_name' => $field,
                'content' => $value,
                'language' => 'pashto',
            ]);
        }
    }
}
