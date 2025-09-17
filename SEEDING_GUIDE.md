# Mount Agro Institution - Database Seeding Guide

## 🔑 Admin Credentials

-   **Email:** zakiullahsafi00@gmail.com
-   **Password:** safi@123
-   **Role:** Super Admin

## 📊 Complete Factory & Seeder System

### ✅ Factories Available (12 Total)

1. **AgriTechToolFactory** - Agricultural technology tools
2. **ContactFactory** - Contact form submissions
3. **GalleryFactory** - Photo galleries with themes
4. **GalleryImageFactory** - Individual gallery images
5. **JobAnnouncementFactory** - Job positions
6. **NewsFactory** - News articles with agricultural content
7. **ProgramRegistrationFactory** - Program registrations
8. **PublicationFactory** - Documents (reports, manuals, etc.)
9. **RfpRfqFactory** - Procurement opportunities
10. **SuccessStoryFactory** - Client success stories
11. **TrainingProgramFactory** - Educational programs
12. **UserFactory** - System users

### ✅ Seeders Available (6 Total)

1. **AdminUserSeeder** - Creates admin accounts
2. **BusinessPillarSeeder** - Training programs, agri-tech tools, etc.
3. **ContentSeeder** - Core content (news, publications, galleries, etc.)
4. **DatabaseSeeder** - Master seeder (runs all others)
5. **NewsSeeder** - Featured news articles
6. **SampleDataSeeder** - Contact forms, registrations, statistics

## 🚀 How to Use

### Seed Everything

```bash
php artisan migrate:fresh --seed
```

### Seed Specific Content

```bash
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=ContentSeeder
php artisan db:seed --class=BusinessPillarSeeder
```

### Generate Additional Content

```bash
php artisan tinker

# Create 10 more news articles
>>> App\Models\News::factory()->published()->count(10)->create()

# Create 5 training programs
>>> App\Models\TrainingProgram::factory()->upcoming()->count(5)->create()

# Create 20 contacts
>>> App\Models\Contact::factory()->count(20)->create()
```

## 📈 Content Generated

### Core Content

-   **News:** 23 articles (18 published, 5 draft)
-   **Publications:** 22 documents (19 published, 3 draft)
-   **Success Stories:** 14 stories (12 published, 2 draft)
-   **Job Announcements:** 16 positions (8 open, 8 closed)
-   **RFP/RFQ:** 10 listings (4 open, 6 closed)
-   **Galleries:** 5 galleries with 35+ images

### Business Pillars

-   **Training Programs:** 18 programs (5 upcoming, 3 ongoing, 10 completed)
-   **Agri-Tech Tools:** 8 published tools
-   **Market Access Programs:** 3 programs
-   **Environmental Projects:** 3 projects
-   **Community Programs:** 3 programs

### Sample Data

-   **Users:** 5 accounts (1 super admin, 4 staff)
-   **Contacts:** 15 inquiries (various statuses)
-   **Registrations:** 25 program registrations
-   **Statistics:** 2 years of beneficiaries data
-   **Translations:** Sample multi-language content

## 🎯 Factory States Available

### News

-   `published()` - Published articles
-   `draft()` - Draft articles

### Training Programs

-   `upcoming()` - Future programs
-   `ongoing()` - Current programs
-   `completed()` - Past programs

### Job Announcements

-   `open()` - Active positions
-   `closed()` - Expired positions
-   `fullTime()` - Full-time positions
-   `contract()` - Contract positions

### Publications

-   `published()` - Published documents
-   `report()` - Research reports
-   `manual()` - User manuals
-   `guideline()` - Policy guidelines

### Success Stories

-   `published()` - Published stories
-   `farming()` - Crop farming stories
-   `livestock()` - Animal farming stories

### Contacts

-   `unread()` - New inquiries
-   `replied()` - Responded inquiries

### Program Registrations

-   `pending()` - Awaiting approval
-   `approved()` - Approved applications
-   `completed()` - Finished programs
-   `forTrainingProgram()` - Training registrations
-   `forCommunityProgram()` - Community registrations

## 🔧 Customization Examples

```php
// Create specific content types
News::factory()->published()->count(5)->create([
    'status' => 'published',
    'published_at' => now()
]);

// Create galleries with specific themes
Gallery::factory()->farmingActivities()->count(3)->create();
Gallery::factory()->trainingEvents()->count(2)->create();

// Create users with specific roles
User::factory()->count(3)->create([
    'role' => 'editor',
    'status' => 'active'
]);
```

## ✅ All Models Ready for Factories

Every model includes the `HasFactory` trait and can be used with factories for unlimited content generation.

---

**Ready for development, testing, and client demos!** 🚀
