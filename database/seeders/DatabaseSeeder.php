<?php

namespace Database\Seeders;

use App\Models\AttorneyProfile;
use App\Models\Document;
use App\Models\Hearing;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Matter;
use App\Models\PracticeArea;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // 2. Create Default Test Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@lexcore.test'],
            [
                'name' => 'Lexis Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        $attorney = User::firstOrCreate(
            ['email' => 'attorney@lexcore.test'],
            [
                'name' => 'Robert J. Sterling',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $attorney->assignRole($staffRole);

        $client = User::firstOrCreate(
            ['email' => 'client@lexcore.test'],
            [
                'name' => 'John Smith',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $client->assignRole($clientRole);

        // 3. Seed Practice Areas
        $corporate = PracticeArea::create([
            'name' => 'Corporate & M&A',
            'slug' => 'corporate-ma',
            'icon' => 'business_center',
            'description' => 'Guiding multi-billion dollar transactions with rigorous due diligence and sophisticated deal structures.',
            'content' => 'Our corporate practice advises public and private companies, private equity funds, and financial institutions on mergers and acquisitions, joint ventures, and capital raising.',
            'is_active' => true,
            'order' => 1,
        ]);

        $ip = PracticeArea::create([
            'name' => 'Intellectual Property',
            'slug' => 'intellectual-property',
            'icon' => 'lightbulb',
            'description' => 'Global portfolio management and aggressive patent protection for innovators.',
            'content' => 'We protect valuable patents, trademarks, and copyrights worldwide, and defend intellectual property rights in federal court litigation.',
            'is_active' => true,
            'order' => 2,
        ]);

        $litigation = PracticeArea::create([
            'name' => 'High-Stakes Litigation',
            'slug' => 'high-stakes-litigation',
            'icon' => 'gavel',
            'description' => 'Uncompromising advocacy in state and federal courts across the country.',
            'content' => 'Our trial attorneys handle complex commercial litigation, white-collar defense, securities class actions, and international arbitration.',
            'is_active' => true,
            'order' => 3,
        ]);

        $wealth = PracticeArea::create([
            'name' => 'Private Wealth',
            'slug' => 'private-wealth',
            'icon' => 'family_history',
            'description' => 'Discreet asset protection and multi-generational legacy planning.',
            'content' => 'We design sophisticated trusts, execute estate plans, and handle tax planning for high-net-worth individuals and family offices.',
            'is_active' => true,
            'order' => 4,
        ]);

        $realestate = PracticeArea::create([
            'name' => 'Commercial Real Estate',
            'slug' => 'commercial-real-estate',
            'icon' => 'apartment',
            'description' => 'Navigating complex zoning, financing, and development challenges.',
            'content' => 'We counsel developers, investors, and lenders through zoning approvals, property acquisitions, leasing agreements, and project financing.',
            'is_active' => true,
            'order' => 5,
        ]);

        // 4. Seed Attorney Profile
        AttorneyProfile::create([
            'user_id' => $attorney->id,
            'title' => 'Senior Litigation Counsel',
            'bio' => 'Robert J. Sterling has over 20 years of experience litigating commercial disputes. He specializes in contract enforcement, class action defense, and international trade regulation.',
            'education' => ['J.D., Harvard Law School', 'B.A., Yale University'],
            'bar_admissions' => ['State Bar of New York', 'U.S. District Court for the Southern District of New York'],
            'experience_years' => 22,
            'social_links' => ['linkedin' => 'https://linkedin.com', 'twitter' => 'https://twitter.com'],
            'is_active' => true,
            'order' => 1,
        ]);

        // 5. Seed Matter (John Smith v. Meridian Corp)
        $matter = Matter::create([
            'case_number' => '2024-CV-1102',
            'title' => 'Smith v. Meridian Corp.',
            'description' => 'Breach of contract and intellectual property infringement regarding the joint development of proprietary logistics software.',
            'client_id' => $client->id,
            'practice_area_id' => $litigation->id,
            'lead_attorney_id' => $attorney->id,
            'status' => 'Discovery',
            'priority' => 'high',
            'court' => 'U.S. District Court, Southern District of New York',
            'judge' => 'Hon. Richard Sullivan',
            'opposing_party' => 'Meridian Corp.',
            'opposing_counsel' => 'Sarah Vance, Esq. (Vance & Associates)',
            'start_date' => '2024-01-15',
            'case_value' => 2500000.00,
        ]);

        // Seed some other dummy matters for admin
        Matter::create([
            'case_number' => '2026-M-0089',
            'title' => 'Apex Corp Acquisition',
            'description' => 'Advising Apex Enterprises Ltd on the acquisition of its primary logistics competitor.',
            'client_id' => $client->id,
            'practice_area_id' => $corporate->id,
            'lead_attorney_id' => $admin->id,
            'status' => 'In Progress',
            'priority' => 'critical',
            'court' => 'N/A (Transactional)',
            'start_date' => '2026-03-01',
            'case_value' => 12500000.00,
        ]);

        // 6. Seed Hearings
        Hearing::create([
            'matter_id' => $matter->id,
            'title' => 'Discovery Status Conference',
            'hearing_date' => now()->addDays(7)->setTime(10, 0, 0),
            'location' => 'Superior Court, Room 402',
            'notes' => 'Parties to submit joint letter detailing outstanding document production disputes.',
            'status' => 'scheduled',
        ]);

        Hearing::create([
            'matter_id' => $matter->id,
            'title' => 'Pre-Trial Motion: Jenkins v. Ford',
            'hearing_date' => now()->addDay()->setTime(10, 0, 0),
            'location' => 'Superior Court, Room 402',
            'notes' => 'Hearing on motion to compel defendant answers to third interrogatory set.',
            'status' => 'scheduled',
        ]);

        Hearing::create([
            'matter_id' => $matter->id,
            'title' => 'Deposition: Estate of Maria Gomez',
            'hearing_date' => now()->addDays(4)->setTime(14, 30, 0),
            'location' => 'Zoom Conference Link Sent',
            'notes' => 'Deposition of executor regarding trust fund assets distribution.',
            'status' => 'scheduled',
        ]);

        // 7. Seed Invoices & Items
        $invoice = Invoice::create([
            'invoice_number' => 'INV-2024-09902',
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'status' => 'unpaid',
            'due_date' => now()->addDays(14),
            'subtotal' => 800.00,
            'tax_rate' => 0.00,
            'total' => 800.00,
            'notes' => 'Thank you for your business.',
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'description' => 'Expert Witness Retainer - Forensic Engineering Services',
            'qty' => 1,
            'unit_price' => 800.00,
            'total' => 800.00,
        ]);

        $invoice2 = Invoice::create([
            'invoice_number' => 'INV-2024-09881',
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'status' => 'unpaid',
            'due_date' => now()->addDays(7),
            'subtotal' => 440.00,
            'tax_rate' => 0.00,
            'total' => 440.00,
            'notes' => 'Filing fees incurred with federal court administration.',
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice2->id,
            'description' => 'Administrative Filing - Amended Complaint Fees',
            'qty' => 1,
            'unit_price' => 440.00,
            'total' => 440.00,
        ]);

        // 8. Seed Documents
        Document::create([
            'title' => 'Final_Settlement_Draft.pdf',
            'filename' => 'Final_Settlement_Draft.pdf',
            'filepath' => 'documents/settlements/final_draft.pdf',
            'file_size' => 1245000,
            'mime_type' => 'application/pdf',
            'uploader_id' => $attorney->id,
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'version' => '1.0',
        ]);

        Document::create([
            'title' => 'Evidence_List_V2.docx',
            'filename' => 'Evidence_List_V2.docx',
            'filepath' => 'documents/discovery/evidence_v2.docx',
            'file_size' => 245000,
            'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'uploader_id' => $attorney->id,
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'version' => '2.0',
        ]);

        Document::create([
            'title' => 'Discovery_Request.docx',
            'filename' => 'Discovery_Request.docx',
            'filepath' => 'documents/discovery/request.docx',
            'file_size' => 189000,
            'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'uploader_id' => $client->id,
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'version' => '1.0',
        ]);

        Document::create([
            'title' => 'Incident_Photo_01.jpg',
            'filename' => 'Incident_Photo_01.jpg',
            'filepath' => 'documents/evidence/incident_01.jpg',
            'file_size' => 3450000,
            'mime_type' => 'image/jpeg',
            'uploader_id' => $client->id,
            'client_id' => $client->id,
            'matter_id' => $matter->id,
            'version' => '1.0',
        ]);

        // 9. Seed Tasks
        Task::create([
            'title' => 'Review Discovery Docs',
            'description' => 'Analyze documents produced by defendant Meridian Corp during initial disclosures.',
            'due_date' => now()->subDays(2),
            'status' => 'pending',
            'priority' => 'high',
            'assignee_id' => $attorney->id,
            'creator_id' => $admin->id,
            'matter_id' => $matter->id,
        ]);

        Task::create([
            'title' => 'Submit Fee Petition',
            'description' => 'Prepare and file petition for recovery of legal fees in connection with sanctions motion.',
            'due_date' => now(),
            'status' => 'pending',
            'priority' => 'high',
            'assignee_id' => $attorney->id,
            'creator_id' => $admin->id,
            'matter_id' => $matter->id,
        ]);

        Task::create([
            'title' => 'Schedule Mediator',
            'description' => 'Align with opposing counsel to select neutral mediator and set mediation date.',
            'due_date' => now()->addDay(),
            'status' => 'pending',
            'priority' => 'medium',
            'assignee_id' => $attorney->id,
            'creator_id' => $admin->id,
            'matter_id' => $matter->id,
        ]);

        Task::create([
            'title' => 'Draft Witness List',
            'description' => 'List all prospective factual and expert witnesses for the upcoming pre-trial statement.',
            'due_date' => now()->subDays(1),
            'status' => 'completed',
            'priority' => 'medium',
            'assignee_id' => $attorney->id,
            'creator_id' => $admin->id,
            'matter_id' => $matter->id,
            'completed_at' => now()->subDays(1),
        ]);
    }
}
