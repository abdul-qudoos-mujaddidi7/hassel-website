import { ref, computed } from "vue";
import en from "../i18n/en.js";
import fa from "../i18n/fa.js";
import ps from "../i18n/ps.js";

// Current language state
const currentLanguage = ref("en");
const translations = ref({});
const isLoading = ref(false);

// Supported languages
export const supportedLanguages = [
    { code: "en", name: "English", nativeName: "English" },
    { code: "fa", name: "Farsi", nativeName: "دری" },
    { code: "ps", name: "Pashto", nativeName: "پښتو" },
];

// Static translations loaded from separate files
const defaultTranslations = {
    en: {
        // Navigation
        "nav.home": "Home",
        "nav.work": "Our Work",
        "nav.programs": "Programs",
        "nav.training": "Training Programs",
        "nav.agri_tech": "Agri-Tech Tools",
        "nav.market_access": "Market Access",
        "nav.smart_farming": "Smart Farming",
        "nav.seed_supply": "Seed Supply",
        "nav.community": "Community Programs",
        "nav.environmental": "Environmental Projects",
        "nav.resources": "Resources",
        "nav.careers": "Careers",
        "nav.contact": "Contact",

        // Common
        "common.loading": "Loading...",
        "common.error": "Error",
        "common.success": "Success",
        "common.read_more": "Read More",
        "common.learn_more": "Learn More",
        "common.apply_now": "Apply Now",
        "common.view_details": "View Details",
        "common.back": "Back",
        "common.next": "Next",
        "common.previous": "Previous",
        "common.submit": "Submit",
        "common.cancel": "Cancel",
        "common.save": "Save",
        "common.edit": "Edit",
        "common.delete": "Delete",
        "common.close": "Close",
        "common.search": "Search",
        "common.filter": "Filter",
        "common.sort": "Sort",
        "common.all": "All",
        "common.none": "None",
        "common.yes": "Yes",
        "common.no": "No",

        // Home page
        "home.hero.title": "Empowering Agricultural Communities",
        "home.hero.subtitle":
            "Building sustainable futures through innovation and education",
        "home.hero.cta_primary": "Get Started",
        "home.hero.cta_secondary": "Learn More",

        // Home page hero slides
        "home.hero2.title": "Comprehensive Training Programs",
        "home.hero2.subtitle":
            "Providing farmers and agricultural professionals with cutting-edge knowledge, skills, and techniques for modern sustainable farming.",
        "home.hero3.title": "Agricultural Technology Solutions",
        "home.hero3.subtitle":
            "Integrating modern technology with traditional farming practices to boost productivity and ensure food security.",
        "home.hero4.title": "Community Development",
        "home.hero4.subtitle":
            "Strengthening rural communities through inclusive programs that promote social development and economic empowerment.",
        "home.hero5.title": "Environmental Conservation",
        "home.hero5.subtitle":
            "Promoting sustainable agricultural practices that protect our environment while ensuring productive and profitable farming.",

        // Home page business pillars
        "home.pillars.training.title": "Training Programs",
        "home.pillars.training.description":
            "Comprehensive agricultural education and capacity building programs for farmers, cooperatives, and agricultural professionals.",
        "home.pillars.training.countLabel": "Programs",
        "home.pillars.agritech.title": "Agri Tech Tools",
        "home.pillars.agritech.description":
            "Modern agricultural technologies and digital solutions to enhance farming productivity and efficiency.",
        "home.pillars.agritech.countLabel": "Tools",
        "home.pillars.smartfarming.title": "Smart & Sustainable Farming",
        "home.pillars.smartfarming.description":
            "Promote modern techniques like drip irrigation, greenhouse farming, and precision agriculture with climate-resilient crops.",
        "home.pillars.smartfarming.countLabel": "Programs",
        "home.pillars.seedSupply.title": "Seed & Input Supply Chain",
        "home.pillars.seedSupply.description":
            "Provide high-quality seeds, fertilizers, and eco-friendly pesticides with reliable distribution networks across provinces.",
        "home.pillars.seedSupply.countLabel": "Products",
        "home.pillars.market.title": "Market Access Programs",
        "home.pillars.market.description":
            "Connecting farmers and agricultural producers to profitable markets and value chains for sustainable income growth.",
        "home.pillars.market.countLabel": "Programs",
        "home.pillars.environmental.title": "Environmental Projects",
        "home.pillars.environmental.description":
            "Sustainable environmental initiatives promoting conservation, climate resilience, and eco-friendly agricultural practices.",
        "home.pillars.environmental.countLabel": "Projects",
        "home.pillars.community.title": "Community Programs",
        "home.pillars.community.description":
            "Comprehensive community development initiatives focusing on rural empowerment, social inclusion, and livelihood improvement.",
        "home.pillars.community.countLabel": "Programs",

        // Home page sections
        "home.about.title": "About Us",
        "home.partners.title": "Our Partners",
        "home.news.view_all": "View All News",

        // Careers page
        "careers.hero.title": "Join Our Team",
        "careers.hero.subtitle": "Build the future of agriculture with us",
        "careers.current_openings": "Current Openings",
        "careers.no_jobs": "No job openings available at the moment",
        "careers.apply_position": "Apply for this Position",
        "careers.refresh_jobs": "Refresh Jobs",
        "careers.location": "Location",
        "careers.deadline": "Deadline",
        "careers.type": "Type",
        "careers.status.open": "Open",
        "careers.status.closed": "Closed",

        // Contact page
        "contact.hero.title": "Get in Touch",
        "contact.hero.subtitle": "We'd love to hear from you",
        "contact.hero.send_message": "Send Message",
        "contact.hero.call_now": "Call Now",
        "contact.form.name": "Full Name",
        "contact.form.email": "Email Address",
        "contact.form.phone": "Phone Number",
        "contact.form.subject": "Subject",
        "contact.form.message": "Message",
        "contact.form.send": "Send Message",
        "contact.form.sending": "Sending...",
        "contact.form.success": "Message sent successfully!",
        "contact.form.error": "Failed to send message. Please try again.",
        "contact.message_placeholder": "Please describe your inquiry in detail...",
        "contact.job_message_placeholder": "Please provide any additional information about your application...",

        // Job application
        "job_application.title": "Job Application",
        "job_application.job_title": "Job Title",
        "job_application.location": "Location",
        "job_application.cover_letter": "Cover Letter",
        "job_application.cv_file": "CV File",
        "job_application.cv_help": "Upload your CV (PDF, DOC, DOCX - Max 5MB)",

        // Subjects
        "subjects.job_application": "Job Application",
        "subjects.technical_support": "Technical Support",
        "subjects.partnership": "Partnership",
        "subjects.project_discussion": "Project Discussion",
        "subjects.general_inquiry": "General Inquiry",
        "subjects.media_inquiry": "Media Inquiry",
        "subjects.other": "Other",

        // Footer
        "footer.follow_us": "Follow Us",
        "footer.quick_links": "Quick Links",
        "footer.contact_info": "Contact Information",
        "footer.copyright": "All rights reserved.",
        "footer.programs": "Programs",
        "footer.contact": "Contact",
        "footer.company_tagline": "Professional solutions for modern challenges. We build tomorrow's technology today.",
        "footer.address": "123 Business Street",
        "footer.city_state": "City, State 12345",
        "footer.phone": "Phone: (555) 123-4567",
        "footer.email": "Email: info@mountagro.com",
        "footer.privacy_policy": "Privacy Policy",
        "footer.terms_of_service": "Terms of Service",

        // Error pages
        "error.404.title": "Page Not Found",
        "error.404.message": "The page you're looking for doesn't exist.",
        "error.404.go_home": "Go Home",
        "error.404.go_back": "Go Back",

        // Loading states
        "loading.page": "Loading page...",
        "loading.content": "Loading content...",
        "loading.jobs": "Loading job openings...",
        "loading.programs": "Loading programs...",
        "loading.please_wait": "Please wait while we prepare the content",

        // Language names
        "english": "English",
        "dari": "Dari",
        "pashto": "Pashto",
        "base_language": "Base Language",
        "farsi_translations": "Dari Translations",
        "pashto_translations": "Pashto Translations",
        "clear_all": "Clear All",

        // Resources page
        "resources.stories.client_label": "Client",

        // Job Announcements
        "job_announcements": "Job Announcements",
    },

    farsi: {
        // Navigation
        "nav.home": "خانه",
        "nav.work": "کار ما",
        "nav.programs": "برنامه ها",
        "nav.training": "برنامه های آموزشی",
        "nav.agri_tech": "ابزارهای کشاورزی",
        "nav.market_access": "دسترسی به بازار",
        "nav.smart_farming": "کشاورزی هوشمند",
        "nav.seed_supply": "تأمین بذر",
        "nav.community": "برنامه های اجتماعی",
        "nav.environmental": "پروژه های محیطی",
        "nav.resources": "منابع",
        "nav.careers": "فرصت های شغلی",
        "nav.contact": "تماس",

        // Common
        "common.loading": "در حال بارگذاری...",
        "common.error": "خطا",
        "common.success": "موفقیت",
        "common.read_more": "بیشتر بخوانید",
        "common.learn_more": "بیشتر بدانید",
        "common.apply_now": "اکنون درخواست دهید",
        "common.view_details": "مشاهده جزئیات",
        "common.back": "بازگشت",
        "common.next": "بعدی",
        "common.previous": "قبلی",
        "common.submit": "ارسال",
        "common.cancel": "لغو",
        "common.save": "ذخیره",
        "common.edit": "ویرایش",
        "common.delete": "حذف",
        "common.close": "بستن",
        "common.search": "جستجو",
        "common.filter": "فیلتر",
        "common.sort": "مرتب سازی",
        "common.all": "همه",
        "common.none": "هیچ",
        "common.yes": "بله",
        "common.no": "خیر",

        // Home page
        "home.hero.title": "توانمندسازی جوامع کشاورزی",
        "home.hero.subtitle": "ساخت آینده پایدار از طریق نوآوری و آموزش",
        "home.hero.cta_primary": "شروع کنید",
        "home.hero.cta_secondary": "بیشتر بدانید",

        // Home page hero slides
        "home.hero2.title": "برنامه های آموزشی جامع",
        "home.hero2.subtitle":
            "ارائه دانش، مهارت و تکنیک های پیشرفته به کشاورزان و متخصصان کشاورزی برای کشاورزی پایدار مدرن.",
        "home.hero3.title": "راه حل های فناوری کشاورزی",
        "home.hero3.subtitle":
            "ادغام فناوری مدرن با روش های کشاورزی سنتی برای افزایش بهره وری و تضمین امنیت غذایی.",
        "home.hero4.title": "توسعه جامعه",
        "home.hero4.subtitle":
            "تقویت جوامع روستایی از طریق برنامه های فراگیر که توسعه اجتماعی و توانمندسازی اقتصادی را ترویج می دهند.",
        "home.hero5.title": "حفاظت از محیط زیست",
        "home.hero5.subtitle":
            "ترویج روش های کشاورزی پایدار که از محیط زیست ما محافظت می کند و در عین حال کشاورزی مولد و سودآور را تضمین می کند.",

        // Home page business pillars
        "home.pillars.training.title": "برنامه های آموزشی",
        "home.pillars.training.description":
            "برنامه های جامع آموزش کشاورزی و ظرفیت سازی برای کشاورزان، تعاونی ها و متخصصان کشاورزی.",
        "home.pillars.training.countLabel": "برنامه ها",
        "home.pillars.agritech.title": "ابزارهای فناوری کشاورزی",
        "home.pillars.agritech.description":
            "فناوری های مدرن کشاورزی و راه حل های دیجیتال برای افزایش بهره وری و کارایی کشاورزی.",
        "home.pillars.agritech.countLabel": "ابزارها",
        "home.pillars.smartfarming.title": "کشاورزی هوشمند و پایدار",
        "home.pillars.smartfarming.description":
            "ترویج تکنیک های مدرن مانند آبیاری قطره ای، کشاورزی گلخانه ای و کشاورزی دقیق با محصولات مقاوم به آب و هوا.",
        "home.pillars.smartfarming.countLabel": "برنامه ها",
        "home.pillars.seedSupply.title": "زنجیره تأمین بذر و نهاده",
        "home.pillars.seedSupply.description":
            "ارائه بذرهای با کیفیت، کودها و آفت کش های سازگار با محیط زیست با شبکه های توزیع قابل اعتماد در سراسر استان ها.",
        "home.pillars.seedSupply.countLabel": "محصولات",
        "home.pillars.market.title": "برنامه های دسترسی به بازار",
        "home.pillars.market.description":
            "اتصال کشاورزان و تولیدکنندگان کشاورزی به بازارهای سودآور و زنجیره های ارزش برای رشد درآمد پایدار.",
        "home.pillars.market.countLabel": "برنامه ها",
        "home.pillars.environmental.title": "پروژه های محیطی",
        "home.pillars.environmental.description":
            "ابتکارات زیست محیطی پایدار که حفاظت، مقاومت در برابر آب و هوا و روش های کشاورزی سازگار با محیط زیست را ترویج می دهند.",
        "home.pillars.environmental.countLabel": "پروژه ها",
        "home.pillars.community.title": "برنامه های جامعه",
        "home.pillars.community.description":
            "ابتکارات جامع توسعه جامعه که بر توانمندسازی روستایی، شمول اجتماعی و بهبود معیشت تمرکز دارد.",
        "home.pillars.community.countLabel": "برنامه ها",

        // Home page sections
        "home.about.title": "درباره ما",
        "home.partners.title": "شرکای ما",
        "home.news.view_all": "مشاهده همه اخبار",

        // Careers page
        "careers.hero.title": "به تیم ما بپیوندید",
        "careers.hero.subtitle": "آینده کشاورزی را با ما بسازید",
        "careers.current_openings": "فرصت های شغلی موجود",
        "careers.no_jobs": "در حال حاضر هیچ فرصت شغلی موجود نیست",
        "careers.apply_position": "برای این موقعیت درخواست دهید",
        "careers.refresh_jobs": "تازه کردن مشاغل",
        "careers.location": "مکان",
        "careers.deadline": "مهلت",
        "careers.type": "نوع",
        "careers.status.open": "باز",
        "careers.status.closed": "بسته",

        // Contact page
        "contact.hero.title": "با ما در تماس باشید",
        "contact.hero.subtitle": "ما دوست داریم از شما بشنویم",
        "contact.hero.send_message": "ارسال پیام",
        "contact.hero.call_now": "اکنون تماس بگیرید",
        "contact.form.name": "نام کامل",
        "contact.form.email": "آدرس ایمیل",
        "contact.form.phone": "شماره تلفن",
        "contact.form.subject": "موضوع",
        "contact.form.message": "پیام",
        "contact.form.send": "ارسال پیام",
        "contact.form.sending": "در حال ارسال...",
        "contact.form.success": "پیام با موفقیت ارسال شد!",
        "contact.form.error": "ارسال پیام ناموفق بود. لطفاً دوباره تلاش کنید.",

        // Job application
        "job_application.title": "درخواست شغل",
        "job_application.job_title": "عنوان شغل",
        "job_application.location": "مکان",
        "job_application.cover_letter": "نامه پوششی",
        "job_application.cv_file": "فایل رزومه",
        "job_application.cv_help":
            "رزومه خود را آپلود کنید (PDF, DOC, DOCX - حداکثر 5MB)",

        // Subjects
        "subjects.job_application": "درخواست شغل",
        "subjects.technical_support": "پشتیبانی فنی",
        "subjects.partnership": "مشارکت",
        "subjects.project_discussion": "بحث پروژه",
        "subjects.general_inquiry": "سوال عمومی",
        "subjects.media_inquiry": "سوال رسانه",
        "subjects.other": "سایر",

        // Footer
        "footer.follow_us": "ما را دنبال کنید",
        "footer.quick_links": "لینک های سریع",
        "footer.contact_info": "اطلاعات تماس",
        "footer.copyright": "تمام حقوق محفوظ است.",
        "footer.programs": "برنامه ها",
        "footer.contact": "تماس",
        "footer.company_tagline": "راه حل های حرفه ای برای چالش های مدرن. ما فناوری فردا را امروز می سازیم.",
        "footer.address": "خیابان تجاری 123",
        "footer.city_state": "شهر، استان 12345",
        "footer.phone": "تلفن: (555) 123-4567",
        "footer.email": "ایمیل: info@mountagro.com",
        "footer.privacy_policy": "سیاست حریم خصوصی",
        "footer.terms_of_service": "شرایط خدمات",

        // Error pages
        "error.404.title": "صفحه یافت نشد",
        "error.404.message": "صفحه ای که دنبال آن هستید وجود ندارد.",
        "error.404.go_home": "برو به خانه",
        "error.404.go_back": "بازگشت",

        // Loading states
        "loading.page": "در حال بارگذاری صفحه...",
        "loading.content": "در حال بارگذاری محتوا...",
        "loading.jobs": "در حال بارگذاری فرصت های شغلی...",
        "loading.programs": "در حال بارگذاری برنامه ها...",
        "loading.please_wait": "لطفاً منتظر بمانید تا محتوا آماده شود",

        // Language names
        "english": "انگلیسی",
        "dari": "دری",
        "pashto": "پښتو",
        "base_language": "زبان پایه",
        "farsi_translations": "ترجمه های دری",
        "pashto_translations": "ترجمه های پښتو",
        "clear_all": "همه را پاک کن",

        // Resources page
        "resources.stories.client_label": "مشتری",

        // Job Announcements
        "job_announcements": "آگهی های شغلی",
        "news_management": "مدیریت خبرها",
        },

    pashto: {
        // Navigation
        "nav.home": "کور",
        "nav.work": "زموږ کار",
        "nav.programs": "پروګرامونه",
        "nav.training": "د روزنې پروګرامونه",
        "nav.agri_tech": "د کرنې وسایل",
        "nav.market_access": "د بازار لاسرسی",
        "nav.smart_farming": "پاملرنې کرنه",
        "nav.seed_supply": "د تخم ورکړه",
        "nav.community": "د ټولنې پروګرامونه",
        "nav.environmental": "د چاپیریال پروژې",
        "nav.resources": "سرچینې",
        "nav.careers": "د دندو فرصتونه",
        "nav.contact": "اړیکه",

        // Common
        "common.loading": "په بارولو کې...",
        "common.error": "تېروتنه",
        "common.success": "بریالیتوب",
        "common.read_more": "نور یې ولولئ",
        "common.learn_more": "نور زده کړئ",
        "common.apply_now": "اوس غوښتنه وکړئ",
        "common.view_details": "تفصیلات وګورئ",
        "common.back": "شاته",
        "common.next": "راتلونکی",
        "common.previous": "پخوانی",
        "common.submit": "ولېږئ",
        "common.cancel": "لغوه کړئ",
        "common.save": "ثبت کړئ",
        "common.edit": "سمون",
        "common.delete": "ړنګ کړئ",
        "common.close": "تړئ",
        "common.search": "پلټنه",
        "common.filter": "فلټر",
        "common.sort": "ترتیب",
        "common.all": "ټول",
        "common.none": "هیڅ",
        "common.yes": "هو",
        "common.no": "نه",

        // Home page
        "home.hero.title": "د کرنیزو ټولنو د پیاوړتیا",
        "home.hero.subtitle": "د نوښت او روزنې له لارې د پایدار راتلونکي جوړول",
        "home.hero.cta_primary": "پیل وکړئ",
        "home.hero.cta_secondary": "نور زده کړئ",

        // Home page hero slides
        "home.hero2.title": "د روزنې جامع پروګرامونه",
        "home.hero2.subtitle":
            "د کرنیزو متخصصینو او کرنیزو متخصصینو لپاره د نن ورځې د پایدار کرنې لپاره د پرمختللي پوهې، مهارتونو او تخنیکونو وړاندې کول.",
        "home.hero3.title": "د کرنې د تخنیکي حل لارې",
        "home.hero3.subtitle":
            "د کرنې د تولید د زیاتولو او د خوړو د امنیت د تضمین لپاره د نن ورځې تخنیک سره د کرنې د سنتي طریقو سره یوځای کول.",
        "home.hero4.title": "د ټولنې پراختیا",
        "home.hero4.subtitle":
            "د ټولنیز پراختیا او اقتصادي پیاوړتیا ترویج کوونکو د شاملولو پروګرامونو له لارې د کلیو ټولنو پیاوړتیا.",
        "home.hero5.title": "د چاپیریال ساتنه",
        "home.hero5.subtitle":
            "د پایدار کرنیزو طریقو ترویج کول چې زموږ چاپیریال ساتي او د تولیدي او ګټور کرنې تضمین کوي.",

        // Home page business pillars
        "home.pillars.training.title": "د روزنې پروګرامونه",
        "home.pillars.training.description":
            "د کرنیزو متخصصینو، تعاونونو او کرنیزو متخصصینو لپاره د کرنې د روزنې او ظرفیت جوړولو جامع پروګرامونه.",
        "home.pillars.training.countLabel": "پروګرامونه",
        "home.pillars.agritech.title": "د کرنې تخنیکي وسایل",
        "home.pillars.agritech.description":
            "د کرنې د تولید د زیاتولو او د کرنې د اغیزمنتوب لپاره د نن ورځې کرنیز تخنیکونه او ډیجیټل حل لارې.",
        "home.pillars.agritech.countLabel": "وسایل",
        "home.pillars.smartfarming.title": "پاملرنې او پایداره کرنه",
        "home.pillars.smartfarming.description":
            "د نن ورځې تخنیکونو ترویج کول لکه د ټپو اوبه ورکول، د ګلخانو کرنه او د اقلیم سره مقاوم محصولاتو سره د دقیق کرنې.",
        "home.pillars.smartfarming.countLabel": "پروګرامونه",
        "home.pillars.seedSupply.title": "د تخم او نهاده د عرضه زنځیر",
        "home.pillars.seedSupply.description":
            "د لوړ کیفیت تخمونه، سره او د چاپیریال سره دوستانه حشره وژونکي د دندو په ټولو ولایتونو کې د باور وړ ویشونکو شبکو سره.",
        "home.pillars.seedSupply.countLabel": "محصولات",
        "home.pillars.market.title": "د بازار د لاسرسي پروګرامونه",
        "home.pillars.market.description":
            "د کرنیزو تولیدونکو او کرنیزو تولیدونکو سره د ګټور بازارونو او د ارزښت زنځیرونو سره د پایدار عاید د ودې لپاره نښلول.",
        "home.pillars.market.countLabel": "پروګرامونه",
        "home.pillars.environmental.title": "د چاپیریال پروژې",
        "home.pillars.environmental.description":
            "د پایدار چاپیریالي ابتکارات چې ساتنه، د اقلیم مقاومت او د چاپیریال سره دوستانه کرنیز طریقې ترویج کوي.",
        "home.pillars.environmental.countLabel": "پروژې",
        "home.pillars.community.title": "د ټولنې پروګرامونه",
        "home.pillars.community.description":
            "د ټولنې د پراختیا جامع ابتکارات چې د کلیو پیاوړتیا، ټولنیز شاملول او د ژوند د ښه والي پراختیا باندې تمرکز کوي.",
        "home.pillars.community.countLabel": "پروګرامونه",

        // Home page sections
        "home.about.title": "زموږ په اړه",
        "home.partners.title": "زموږ شریکان",
        "home.news.view_all": "ټول خبرونه وګورئ",

        // Careers page
        "careers.hero.title": "زموږ ټیم سره یوځای شئ",
        "careers.hero.subtitle": "د کرنې راتلونکی زموږ سره جوړ کړئ",
        "careers.current_openings": "د دندو موجود فرصتونه",
        "careers.no_jobs": "اوس مهال د دندو هیڅ فرصت نشته",
        "careers.apply_position": "د دې دندې لپاره غوښتنه وکړئ",
        "careers.refresh_jobs": "د دندو تازه کول",
        "careers.location": "ځای",
        "careers.deadline": "وخت",
        "careers.type": "ډول",
        "careers.status.open": "خلاص",
        "careers.status.closed": "تړل شوی",

        // Contact page
        "contact.hero.title": "زموږ سره اړیکه ونیسئ",
        "contact.hero.subtitle": "موږ غواړو له تاسو څخه واورو",
        "contact.hero.send_message": "پیغام ولیږئ",
        "contact.hero.call_now": "اوس اړیکه ونیسئ",
        "contact.form.name": "بشپړ نوم",
        "contact.form.email": "د بریښنالیک پته",
        "contact.form.phone": "د تلیفون شمیره",
        "contact.form.subject": "موضوع",
        "contact.form.message": "پیغام",
        "contact.form.send": "پیغام ولیږئ",
        "contact.form.sending": "په لیږلو کې...",
        "contact.form.success": "پیغام په بریالیتوب سره ولېږل شو!",
        "contact.form.error":
            "د پیغام لیږل ناکام شو. مهرباني وکړئ بیا هڅه وکړئ.",

        // Job application
        "job_application.title": "د دندې غوښتنه",
        "job_application.job_title": "د دندې نوم",
        "job_application.location": "ځای",
        "job_application.cover_letter": "د پوښلو لیک",
        "job_application.cv_file": "د CV فایل",
        "job_application.cv_help":
            "خپل CV اپلوډ کړئ (PDF, DOC, DOCX - تر 5MB پورې)",

        // Subjects
        "subjects.job_application": "د دندې غوښتنه",
        "subjects.technical_support": "تخنیکي ملاتړ",
        "subjects.partnership": "شریکوالی",
        "subjects.project_discussion": "د پروژې بحث",
        "subjects.general_inquiry": "عمومي پوښتنه",
        "subjects.media_inquiry": "د رسنیو پوښتنه",
        "subjects.other": "نور",

        // Footer
        "footer.follow_us": "زموږ تعقیب وکړئ",
        "footer.quick_links": "د ژر لینکونه",
        "footer.contact_info": "د اړیکو معلومات",
        "footer.copyright": "ټول حقونه ساتل شوي.",
        "footer.programs": "پروګرامونه",
        "footer.contact": "اړیکه",
        "footer.company_tagline": "د نن ورځې د ستونزو لپاره مسلکي حل لارې. موږ د راتلونکي تخنیک نن جوړوو.",
        "footer.address": "د سوداګرۍ کوڅه 123",
        "footer.city_state": "ښار، ولایت 12345",
        "footer.phone": "تلیفون: (555) 123-4567",
        "footer.email": "بریښنالیک: info@mountagro.com",
        "footer.privacy_policy": "د محرمیت پالیسي",
        "footer.terms_of_service": "د خدماتو شرطونه",

        // Error pages
        "error.404.title": "پاڼه ونه موندل شوه",
        "error.404.message": "هغه پاڼه چې تاسو یې لټوئ شتون نلري.",
        "error.404.go_home": "کور ته لاړ شئ",
        "error.404.go_back": "شاته",

        // Loading states
        "loading.page": "په پاڼه بارولو کې...",
        "loading.content": "په محتوا بارولو کې...",
        "loading.jobs": "په دندو فرصتونو بارولو کې...",
        "loading.programs": "په پروګرامونو بارولو کې...",
        "loading.please_wait": "مهرباني وکړئ انتظار وکړئ ترڅو محتوا چمتو شي",

        // Language names
        "english": "انګلیسي",
        "dari": "دری",
        "pashto": "پښتو",
        "base_language": "اساسي ژبه",
        "farsi_translations": "د دری ژبې ژباړې",
        "pashto_translations": "د پښتو ژبې ژباړې",
        "clear_all": "ټول پاک کړئ",

        // Resources page
        "resources.stories.client_label": "مشتری",

        // Job Announcements
        "job_announcements": "د دندو اعلانات",
    },
    en,
    fa: fa,
    ps: ps,
};

export function useI18n() {
    const normalizeLanguageCode = (code) => {
        const map = {
            farsi: "fa",
            fa: "fa",
            pashto: "ps",
            ps: "ps",
            english: "en",
            en: "en",
        };
        return map[String(code || "en").toLowerCase()] || "en";
    };
    // Get translation for a key
    const t = (key, params = {}) => {
        const translation =
            translations.value[currentLanguage.value]?.[key] ||
            defaultTranslations[currentLanguage.value]?.[key] ||
            defaultTranslations.en[key] ||
            key;


        // Replace parameters in translation
        return Object.keys(params).reduce((str, param) => {
            return str.replace(`{${param}}`, params[param]);
        }, translation);
    };

    // Change language
    const setLanguage = async (lang) => {
        if (!supportedLanguages.find((l) => l.code === lang)) {
            console.warn(`Language ${lang} is not supported`);
            return;
        }

        // Normalize the language code
        const normalizedLang = normalizeLanguageCode(lang);
        currentLanguage.value = normalizedLang;

        // Store in localStorage
        localStorage.setItem("preferred_language", lang);

        // Load translations for the language
        await loadTranslations(normalizedLang);

        // Update document language and direction
        document.documentElement.lang = normalizedLang;
        const isRtl = ["fa", "ps"].includes(normalizedLang);
        document.documentElement.dir = isRtl ? "rtl" : "ltr";
        
        // Add/remove RTL class to body
        document.body.classList.toggle('rtl', isRtl);
        document.body.classList.toggle('ltr', !isRtl);

        // Notify app to refetch data as needed
        try {
            window.dispatchEvent(
                new CustomEvent("language:changed", { detail: { lang: normalizedLang } })
            );
        } catch (_) {}
    };

    // Subscribe utility
    const onLanguageChange = (handler) => {
        window.addEventListener("language:changed", handler);
        return () => window.removeEventListener("language:changed", handler);
    };

    // Load translations (simplified - external files already included in defaultTranslations)
    const loadTranslations = async (lang) => {
        isLoading.value = true;
        try {
            // Use default translations directly (external files already included)
            translations.value[lang] = defaultTranslations[lang] || defaultTranslations.en;
        } catch (error) {
            console.error(`Failed to load translations for ${lang}:`, error);
            // Fallback to default translations
            translations.value[lang] = defaultTranslations[lang] || defaultTranslations.en;
        }
        isLoading.value = false;
    };

    // Initialize i18n
    const init = async () => {
        // Get language from localStorage or browser
        const savedLang = localStorage.getItem("preferred_language");
        const browserLang = navigator.language.split("-")[0];

        const lang =
            savedLang ||
            supportedLanguages.find((l) => l.code === browserLang)?.code ||
            "en";

        await setLanguage(lang);
    };

    // Get current language info
    const currentLangInfo = computed(() => {
        return (
            supportedLanguages.find((l) => l.code === currentLanguage.value) ||
            supportedLanguages[0]
        );
    });

    // Check if RTL language
    const isRTL = computed(() => {
        return ["fa", "ps"].includes(currentLanguage.value);
    });

    return {
        // State
        currentLanguage: computed(() => currentLanguage.value),
        currentLangInfo,
        isLoading: computed(() => isLoading.value),
        isRTL,
        supportedLanguages,
        // Normalized API language code (en/fa/ps)
        apiLanguage: computed(() => normalizeLanguageCode(currentLanguage.value)),

        // Methods
        t,
        setLanguage,
        loadTranslations,
        init,
        onLanguageChange,
        getApiLang: () => normalizeLanguageCode(
            localStorage.getItem("preferred_language") || currentLanguage.value
        ),
    };
}
