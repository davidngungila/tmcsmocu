SOFTWARE REQUIREMENTS SPECIFICATION (SRS)
For TmcsSmart: A Web-Based Church Management Information System for St. Joseph Chaplaincy Moshi Co-operative University
Version 3.0 – Final

Prepared by:
David Rashid Ngungila & Anna Pius Moshiro

Supervisor:
Dr. Shadrack Madila

Institution:
Moshi Co-operative University (MoCU)
Bachelor of Business Information and Communication Technology

Date: April, 2026

TABLE OF CONTENTS
INTRODUCTION
1.1 Purpose
1.2 Document Conventions
1.3 Intended Audience
1.4 Product Scope
1.5 References

OVERALL DESCRIPTION
2.1 Product Perspective
2.2 Organizational Structure of St. Joseph Chaplaincy
2.3 Product Functions
2.4 User Characteristics (Roles)
2.5 Operating Environment
2.6 Design and Implementation Constraints
2.7 Assumptions and Dependencies

SYSTEM FEATURES AND REQUIREMENTS
3.1 User Registration and Authentication
3.2 Member Registration Module (Students & Non‑Students)
3.3 Financial Management Module
3.4 Certificate Generation Module
3.5 Certificate Verification Module
3.6 Communication Engine (SMS & Email)
3.7 Event Management Module (with Chairperson Appointment)
3.8 Election Management Module
3.9 Asset Tracking Module
3.10 Shop Management (POS) Module
3.11 Reporting Dashboards
3.12 Payment Integration (Snipe & Click Pesa)
3.13 Role‑Based Access Control (based on Org Structure)
3.14 System Administration
3.15 Financial Year Management (System Setting)

EXTERNAL INTERFACE REQUIREMENTS
4.1 User Interfaces (including Sidebar)
4.2 Hardware Interfaces
4.3 Software Interfaces
4.4 Communication Interfaces

NON‑FUNCTIONAL REQUIREMENTS
5.1 Performance
5.2 Security
5.3 Reliability
5.4 Availability
5.5 Maintainability
5.6 Usability
5.7 Scalability

OTHER REQUIREMENTS
6.1 Legal and Regulatory
6.2 Data Migration
6.3 Training

APPENDICES

Appendix A: Use Case Diagram

Appendix B: Data Dictionary (Key Tables)

Appendix C: Glossary

Appendix D: Full Sidebar Menu by Role

1. INTRODUCTION
1.1 Purpose
This Software Requirements Specification (SRS) documents all requirements for TmcsSmart, a web‑based Church Management Information System for St. Joseph Chaplaincy at Moshi Co‑operative University (MoCU). The system digitises membership, finances, certificates, events (with chairperson appointment), elections, assets, and shop management, while respecting the unique hierarchical structure of the chaplaincy and supporting financial year management as a system setting.

1.2 Document Conventions
Convention	Meaning
REQ‑X.Y.Z	Unique requirement identifier
Shall / Must	Mandatory requirement
Should	Recommended requirement
May	Optional requirement
FY	Financial Year
1.3 Intended Audience
Developers – implement the system

Supervisor (Dr. Shadrack Madila) – evaluate completeness

Chaplain (Rev. Fr. Dominic Kimboi) – validate business needs

MoCU Examination Committee – project assessment

Future maintainers – understand design






1.4 Product Scope
TmcsSmart provides a complete digital platform for:

Member registration for students (with academic programme validation) and non‑students (employees, children with guardian).

Financial management with digital receipts (PDF, SMS, email) and financial year switching.

Automatic certificate generation with QR code verification.

Communication via NextSMS and email.

Event management – leaders regulate events and may appoint a chairperson from leadership.

Election management (nomination, interview, voting/appointment).

Asset tracking and shop POS.

Role‑based access mirroring the chaplaincy’s organisation.

Financial year management configured in system settings, ensuring all reports and transactions respect the currently active financial year.

1.5 References
MoCU Guidelines for Writing Proposals, 4th Edition (2020)

NextSMS API, Snipe API, Click Pesa API documentation

Laravel 10.x Documentation

Tanzania Data Protection Act, Cap. 11

2. OVERALL DESCRIPTION
2.1 Product Perspective
TmcsSmart is a new web‑based system (Laravel, MySQL, Bootstrap) replacing manual paper records. It integrates with external services: NextSMS (SMS), Snipe/Click Pesa (mobile money), SMTP (email). The architecture is three‑tier: presentation (responsive web), application (PHP), data (MySQL).

2.2 Organizational Structure of St. Joseph Chaplaincy
text
CHAPLAIN
│
├── CHAPLAIN LEADERSHIP COUNCIL
│   ├── Chairperson (Employee) – oversees employee & general affairs
│   └── Chairperson (Student) – supervises all student operations
│
├── SECRETARY (Main + Deputy)
├── TREASURER (Main + Deputy)
│
├── SPIRITUAL COMMUNITIES (based on academic programmes)
│   │   Each Community has: Chairperson, Secretary, Treasurer
│   │   (e.g., BAPSM, BBICT, BHRM, LL.B communities)
│   │
│   └── SPIRITUAL COORDINATORS (selected from each programme)
│       – One or more per programme; connect class/community to main church activities
│
├── SPIRITUAL GROUPS (Vyama vya Kitume)
│   │   Each Group has: Chairperson, Secretary, Treasurer, Deputies
│   │   – Choir (Kwaya), Legion of Mary, Charismatic Renewal, etc.
│
├── KAMATI (Committees)
│   ├── Liturgical Committee
│   ├── Decoration Committee
│   └── Table of Sales (Small Shop – religious items)
│
└── MEMBERS
    ├── Students (all programmes)
    └── Non‑Student Members (Employees, Children with guardian)
2.3 Product Functions (Summary)
User & Member Management

Financial Management (with FY switching)

Certificate Generation & Verification

Communication (SMS/Email)

Event Management (with chairperson appointment)

Election Management

Asset Tracking

Shop POS

Reporting (20+ reports, dashboards)

System Administration (including Financial Year setup)

2.4 User Characteristics (Roles)
Role	Description
Super Admin	Full system control
Chaplain	Overall head
Chairperson (Employee/Student)	Co‑leadership
Secretary (Main/Deputy)	Records, correspondence
Treasurer (Main/Deputy)	Finances
Spiritual Coordinator	Liaison for academic programme
Community Leader	Manages a Spiritual Community
Group Leader	Manages a Spiritual Group
Kamati Head	Manages a committee
Member (Student/Employee/Child)	Regular member
Event Chairperson (temporary)	Appointed for a specific event
2.5 Operating Environment
Server: Linux, PHP 8.1+, MySQL 8.0+, Apache/Nginx, SSL certificate

Client: Modern browser (Chrome, Firefox, Safari, Edge) on desktop or mobile

Internet: Required for all operations

External: NextSMS, Snipe, Click Pesa, SMTP server

2.6 Design and Implementation Constraints
Must use Laravel 10.x, MySQL, Bootstrap 5, Alpine.js

Bilingual (English/Swahili)

HTTPS only

Completed within 24 weeks

2.7 Assumptions and Dependencies
Chaplaincy has reliable internet

Members have mobile phones for SMS/email

Leaders willing to adopt digital system

External APIs available and functional

3. SYSTEM FEATURES AND REQUIREMENTS
3.1 User Registration and Authentication
ID	Requirement
REQ‑AUTH‑01	Users register with email and phone number; verification via email link and SMS OTP.
REQ‑AUTH‑02	Login with email/phone and password.
REQ‑AUTH‑03	Forgot password reset via email.
REQ‑AUTH‑04	Session timeout after 60 minutes.
REQ‑AUTH‑05	Account lock after 5 failed attempts (15 minutes).
3.2 Member Registration Module
ID	Requirement
REQ‑MEM‑01	Support Student, Employee, Child member types.
REQ‑MEM‑02	Student: full name, registration number (validated format MoCU/XXX/XXX/XX), academic programme (from MoCU list), year of study, phone, email, photo. Class‑specific link provided by Spiritual Coordinator.
REQ‑MEM‑03	Employee: full name, employee ID (optional), department, phone, email, photo.
REQ‑MEM‑04	Child: full name, date of birth, guardian name, guardian phone, photo; account linked to guardian.
REQ‑MEM‑05	Automatic assignment to Spiritual Community based on academic programme (students).
REQ‑MEM‑06	Members may join any Spiritual Group (Choir, Legion, Charismatic, etc.).
REQ‑MEM‑07	Students become “Alumni” after graduation year; retain limited access.
3.3 Financial Management Module
ID	Requirement
REQ‑FIN‑01	Record contribution types: Almsgiving (Zaka), Sadaka, Project, Other.
REQ‑FIN‑02	Cash contributions recorded manually by Treasurer.
REQ‑FIN‑03	Mobile money contributions automatically recorded via Snipe/Click Pesa webhook.
REQ‑FIN‑04	Upon recording, generate PDF receipt (unique number), send SMS thank you, send PDF via email.
REQ‑FIN‑05	All receipts stored permanently; member can view/download all receipts anytime.
REQ‑FIN‑06	Members can filter contribution history by date range and type.
REQ‑FIN‑07	Expenses recorded (description, amount, date, category, receipt attachment).
REQ‑FIN‑08	Monthly financial report (income by type, expenses, balance).
REQ‑FIN‑09	Financial records cannot be deleted; corrections via reversal entries.
REQ‑FIN‑10	Export financial data to Excel/PDF.
REQ‑FIN‑11	Calculate total giving per member per financial year.
3.4 Certificate Generation Module
ID	Requirement
REQ‑CERT‑01	Pre‑designed templates: Finalist, Group Participation, Leadership, Event.
REQ‑CERT‑02	Chaplain or authorized leader selects template and member group.
REQ‑CERT‑03	Auto‑generate PDF certificates with name, photo, date, QR code.
REQ‑CERT‑04	QR code encodes verification URL with unique certificate ID.
REQ‑CERT‑05	Batch generation up to 200 certificates (<30 seconds).
REQ‑CERT‑06	Certificates stored; member can download from dashboard.
REQ‑CERT‑07	Chaplain approval workflow optional.
REQ‑CERT‑08	Auto‑detect finalist students and prompt certificate generation.
3.5 Certificate Verification Module
ID	Requirement
REQ‑VER‑01	Public verification page (no login required).
REQ‑VER‑02	Accept QR code scan or manual certificate ID entry.
REQ‑VER‑03	Display: member name, certificate type, issue date, issuing authority, “VALID” status.
REQ‑VER‑04	If not found, display “INVALID – Certificate not found.”
REQ‑VER‑05	Log each verification attempt (timestamp, IP, certificate ID).
REQ‑VER‑06	Mobile‑friendly.
3.6 Communication Engine
ID	Requirement
REQ‑COM‑01	Integrate with NextSMS API for SMS (Vodacom, Airtel, Tigo, Halotel).
REQ‑COM‑02	Send SMS for: contribution thanks, meeting reminders, election notifications, broadcasts.
REQ‑COM‑03	Send email via SMTP for: digital receipts, event reminders, certificate notifications, password reset.
REQ‑COM‑04	Authorized users send bulk SMS/email to members of their group.
REQ‑COM‑05	Log all sent messages (recipient, content, timestamp, status).
REQ‑COM‑06	Schedule messages for future date/time.
REQ‑COM‑07	Message templates for consistency.
3.7 Event Management Module (with Chairperson Appointment)
ID	Requirement
REQ‑EVT‑01	Any authorised leader (Chaplain, Chaplain Leadership, Spiritual Coordinator, Community Leader, Group Leader, Kamati Head) may create an event.
REQ‑EVT‑02	Event creation requires: title, description, date/time, location, estimated budget, regulating leader.
REQ‑EVT‑03	The regulating leader may appoint a chairperson from within chaplaincy leadership (dropdown of eligible leaders).
REQ‑EVT‑04	Appointed chairperson has authority to manage tasks, approve changes, represent event. Chairperson’s name displayed on event details.
REQ‑EVT‑05	Regulating leader or chairperson can assign tasks to members, set deadlines, track completion.
REQ‑EVT‑06	Reminders (SMS/email) sent 3 days, 1 day, 2 hours before event.
REQ‑EVT‑07	Attendance tracking: member confirmation via link; leaders can mark manually.
REQ‑EVT‑08	After event, regulating leader or chairperson submits post‑event report (actual expenses vs budget, feedback).
REQ‑EVT‑09	Event summary report: attendance count, expenses, task completion, chairperson’s name.
REQ‑EVT‑10	Members see events they are invited to on dashboard.
REQ‑EVT‑11	Log all event actions (creation, chairperson appointment, changes, report).
3.8 Election Management Module
ID	Requirement
REQ‑ELEC‑01	Support two methods: Voting‑based and Appointment‑based.
REQ‑ELEC‑02	Workflow: (1) Nomination, (2) Interview scheduling & tracking, (3) Final selection (vote or appointment), (4) Result publication.
REQ‑ELEC‑03	Election Officer sets nomination/interview/voting dates.
REQ‑ELEC‑04	Members nominate candidates via system (record nominator, timestamp).
REQ‑ELEC‑05	Record interview outcomes (score, notes, recommendation).
REQ‑ELEC‑06	Voting: display candidates, one vote per voter, anonymous, automatic counting, results after voting closes.
REQ‑ELEC‑07	Appointment: Chaplain selects appointee and records reason.
REQ‑ELEC‑08	Complete audit trail.
REQ‑ELEC‑09	Publish results on public page.
REQ‑ELEC‑10	Only eligible members (community/group) can vote.
3.9 Asset Tracking Module
ID	Requirement
REQ‑ASSET‑01	Record assets: name, description, serial number, purchase date/cost, condition, location, assigned user.
REQ‑ASSET‑02	Upload up to 5 photos per asset.
REQ‑ASSET‑03	Check out asset to member with expected return date.
REQ‑ASSET‑04	Send reminders for overdue returns.
REQ‑ASSET‑05	Schedule maintenance tasks and reminders.
REQ‑ASSET‑06	Generate asset inventory report.
REQ‑ASSET‑07	Assets cannot be deleted; mark as “Disposed” or “Lost”.
3.10 Shop Management (POS) Module
ID	Requirement
REQ‑SHOP‑01	Add products: name, category, description, unit price, stock quantity, reorder level.
REQ‑SHOP‑02	Support cash or mobile money sales.
REQ‑SHOP‑03	Each sale generates digital receipt (PDF) sent to buyer via SMS/email.
REQ‑SHOP‑04	Auto‑reduce stock on sale.
REQ‑SHOP‑05	Alert when stock below reorder level.
REQ‑SHOP‑06	Daily/weekly/monthly sales reports (total sales, profit, top‑selling items).
REQ‑SHOP‑07	Stocktaking adjustment with reason.
REQ‑SHOP‑08	Calculate profit per item and total profit.
3.11 Reporting Dashboards
ID	Requirement
REQ‑RPT‑01	Role‑specific dashboards.
REQ‑RPT‑02	Chaplain dashboard: total members, contributions (monthly/yearly), pending certificates, upcoming events, asset summary, shop sales.
REQ‑RPT‑03	At least 20 report types: membership lists, contribution reports, receipt history, certificate log, event attendance, election results, asset inventory, shop sales.
REQ‑RPT‑04	Export to PDF, Excel, print.
REQ‑RPT‑05	Visual charts (Chart.js).
REQ‑RPT‑06	Scheduled report generation (e.g., monthly financial report emailed to Chaplain).
3.12 Payment Integration (Snipe & Click Pesa)
ID	Requirement
REQ‑PAY‑01	Integrate with Snipe API and Click Pesa API.
REQ‑PAY‑02	Support manual recording (user enters transaction ID) and automatic via webhook.
REQ‑PAY‑03	Store transaction details: transaction ID, amount, phone, gateway, timestamp, status.
REQ‑PAY‑04	Handle failures gracefully; allow retry.
3.13 Role‑Based Access Control (based on Org Structure)
ID	Requirement
REQ‑RBAC‑01	Implement roles: Super Admin, Chaplain, ChairpersonEmployee, ChairpersonStudent, SecretaryMain, SecretaryDeputy, TreasurerMain, TreasurerDeputy, SpiritualCoordinator, CommunityLeader (per community), GroupLeader (per group), KamatiHead (Liturgical/Decoration/TableSales), Member (Student/Employee/Child).
REQ‑RBAC‑02	Permissions as defined in Appendix D (Sidebar Menu by Role).
REQ‑RBAC‑03	Event chairperson receives temporary permissions for that event only.
3.14 System Administration
ID	Requirement
REQ‑ADMIN‑01	Backup feature (MySQL dump + uploaded files).
REQ‑ADMIN‑02	Configure system settings: site name, SMS API keys, payment gateway keys, email SMTP, financial year settings.
REQ‑ADMIN‑03	Activity log of all user actions.
REQ‑ADMIN‑04	System health check page (database, API status).
3.15 Financial Year Management (System Setting)
This is a critical module configured in System Settings and affects all financial operations.

ID	Requirement
REQ‑FY‑01	The system shall allow Super Admin and Chaplain (and delegated Treasurer) to define financial years. Each financial year has: unique name (e.g., “2025/2026”), start date, end date, and status (Open / Closed).
REQ‑FY‑02	Exactly one financial year shall be marked as “Active” at any time. The active year determines the default financial data shown across the system.
REQ‑FY‑03	The active financial year is set in System Settings → Financial Year. Users with appropriate permission (Super Admin, Chaplain, Treasurer) can change the active year.
REQ‑FY‑04	When a financial year is closed:
- No new transactions can be added to that year unless re‑opened.
- The system automatically calculates closing balance and creates an opening balance record for the next financial year (if it exists).
- A year‑end report is generated (income, expenses, balance).
REQ‑FY‑05	Every financial transaction (contribution, expense, receipt) shall be tagged with the financial year ID at creation. This tagging is automatic based on the transaction date falling within the financial year’s start/end dates.
REQ‑FY‑06	The system shall provide a financial year selector in the sidebar (or top bar) for users with financial view permissions. The selector shows:
- Currently active financial year (labelled “Active”)
- List of all previous (closed) financial years
- Option to create a new financial year (if permitted)
REQ‑FY‑07	When a user selects a different financial year from the selector, all financial data on the current page (dashboards, contribution lists, receipts, expense reports, charts) shall immediately refresh to show data for that selected year. The selected year is stored in the user’s session or as a URL parameter, persisting across pages.
REQ‑FY‑08	For users without financial permissions (e.g., regular Members), the “My Contributions” page shall default to the active financial year but may allow the member to select previous years to view their own history.
REQ‑FY‑09	All financial reports (contribution summary, income/expense statement, member giving history) shall include a filter by financial year. The default filter is the currently active financial year.
REQ‑FY‑10	The system shall validate that a transaction date falls within an existing financial year. If no financial year covers the date, the transaction cannot be recorded (error message: “No active financial year covers this date. Please check financial year settings.”).
REQ‑FY‑11	When a financial year is re‑opened (after being closed), the system shall log the action (who, when, reason). All transactions added during the re‑opened period are clearly marked and appear in audit logs.
REQ‑FY‑12	The system shall prevent deleting a financial year that has any transactions. Only years with zero transactions may be deleted.
REQ‑FY‑13	A year‑end closing process shall be available as a system action. It shall:
- Verify all transactions are complete.
- Generate a PDF year‑end financial statement.
- Set the year status to “Closed”.
- If a next financial year exists, update its opening balance.
- Send notification to Chaplain and Treasurer.
4. EXTERNAL INTERFACE REQUIREMENTS
4.1 User Interfaces (including Sidebar)
ID	Requirement
UI‑01	Responsive design (Bootstrap 5) compatible with desktop, tablet, mobile (320px – 1920px).
UI‑02	Bilingual (English/Swahili) toggle.
UI‑03	Real‑time form validation with clear error messages.
UI‑04	QR scanner for certificate verification (camera access).
UI‑05	Loading indicators for operations >2 seconds.
UI‑06	Dashboard uses Chart.js for visualisations.
UI‑07	Sidebar menu as defined in Appendix D (role‑specific, collapsible, with financial year selector at top).
UI‑08	Financial year selector displayed as a dropdown in sidebar or top bar for authorised roles.
UI‑09	Print support for receipts and certificates.
4.2 Hardware Interfaces
Standard input devices (keyboard, mouse, touch).

Camera for QR scanning (user permission required).

Printer (browser print).

4.3 Software Interfaces
External System	Interface Type
NextSMS	REST API
Snipe	REST API + Webhook
Click Pesa	REST API + Webhook
SMTP Server	SMTP (587/465)
MySQL	PDO
4.4 Communication Interfaces
HTTPS (TLS 1.2+) for all client‑server communication.

External APIs over HTTPS.

Retry logic for API calls (up to 3 attempts).

5. NON‑FUNCTIONAL REQUIREMENTS
5.1 Performance
ID	Requirement
PERF‑01	Page load ≤3 seconds under 50 concurrent users.
PERF‑02	Batch certificate generation (100) ≤30 seconds.
PERF‑03	Support ≥100 concurrent users (e.g., election voting).
PERF‑04	Database queries paginated for >500 rows.
PERF‑05	SMS API timeout ≤10 seconds.
5.2 Security
ID	Requirement
SEC‑01	Passwords hashed with bcrypt (cost 10+).
SEC‑02	CSRF tokens on all state‑changing requests.
SEC‑03	Escape user input to prevent XSS.
SEC‑04	Prepared statements to prevent SQL injection.
SEC‑05	Session cookies: HttpOnly, Secure, SameSite=Lax.
SEC‑06	File uploads: JPEG/PNG, max 5MB.
SEC‑07	API keys stored in environment variables.
SEC‑08	Log failed logins and suspicious activities.
5.3 Reliability
ID	Requirement
REL‑01	Uptime 99.5% (excluding scheduled maintenance).
REL‑02	Daily automated database backups (30‑day retention).
REL‑03	Queue failed API messages/transactions for retry.
REL‑04	Database transactions to prevent corruption.
5.4 Availability
24/7 availability.

Scheduled maintenance (max 2 hours/month) announced 48h in advance.

Certificate verification page remains available during maintenance.

5.5 Maintainability
Follow Laravel coding standards (PSR‑12).

Documented database schema.

README with setup instructions.

Modular code (controllers, services, repositories).

5.6 Usability
ID	Requirement
USE‑01	New users complete core tasks within 5 minutes without training.
USE‑02	Tooltips and help icons.
USE‑03	“Help” section with FAQ and contact.
USE‑04	Consistent navigation (sidebar for desktop, bottom tabs for mobile).
USE‑05	User‑friendly error messages.
5.7 Scalability
Modular architecture for adding new modules.

Database supports up to 10,000 members, 1 million transactions.

Deployable on cloud hosting (DigitalOcean, AWS).

6. OTHER REQUIREMENTS
6.1 Legal and Regulatory
Comply with Tanzania Data Protection Act.

Privacy policy page.

Certificate disclaimer: “Electronically generated – verify at [URL]”.

6.2 Data Migration
CSV import for members and financial records (where available).

Validation and error reporting during import.

6.3 Training
User manual (PDF).

2‑hour training for Chaplain, Secretaries, Treasurers, and all leaders who may appoint event chairpersons.

Video tutorials for common tasks.

APPENDICES
Appendix A: Use Case Diagram (Simplified)
text
┌─────────────────────────────────────────────────────────────────────────────┐
│                           TmcsSmart System                                   │
│                                                                              │
│  ┌─────────────┐      ┌──────────────────────────────────────────────────┐  │
│  │  Chaplain   │─────▶│ Manage Certificates, Elections                   │  │
│  └─────────────┘      │ Appoint Event Chairperson, Set Financial Year    │  │
│  ┌─────────────┐      └──────────────────────────────────────────────────┘  │
│  │Chairperson  │─────▶│ Create Event, Regulate, Appoint Chairperson        │  │
│  └─────────────┘                                                           │  │
│  ┌─────────────┐      ┌──────────────────────────────────────────────────┐  │
│  │Spiritual    │─────▶│ Manage own class members, events                  │  │
│  │Coordinator  │      │ Appoint chairperson for class events              │  │
│  └─────────────┘      └──────────────────────────────────────────────────┘  │
│  ┌─────────────┐      ┌──────────────────────────────────────────────────┐  │
│  │ Event       │─────▶│ Manage tasks, attendance, post‑event report      │  │
│  │ Chairperson │      │ (temporary)                                      │  │
│  └─────────────┘      └──────────────────────────────────────────────────┘  │
│  ┌─────────────┐      ┌──────────────────────────────────────────────────┐  │
│  │   Member    │─────▶│ View own profile, receipts, certificates, events │  │
│  └─────────────┘      │ Vote, confirm attendance                         │  │
└─────────────────────────────────────────────────────────────────────────────┘
Appendix B: Data Dictionary (Key Tables)
Table: financial_years

Column	Type	Description
id	BIGINT UNSIGNED	Primary key
name	VARCHAR(20)	e.g., “2025/2026”
start_date	DATE	First day of FY
end_date	DATE	Last day of FY
status	ENUM	‘open’, ‘closed’
is_active	BOOLEAN	Exactly one TRUE
opening_balance	DECIMAL(12,2)	Carried from previous FY
closing_balance	DECIMAL(12,2)	Calculated on closure
closed_at	TIMESTAMP	Nullable
closed_by	BIGINT UNSIGNED	User who closed
Table: financial_transactions (add column)

Column	Type	Description
financial_year_id	BIGINT UNSIGNED	FK to financial_years
Table: events

Column	Type	Description
regulating_leader_id	BIGINT UNSIGNED	User ID of leader regulating event
appointed_chairperson_id	BIGINT UNSIGNED	User ID of event chairperson (nullable)
Appendix C: Glossary
Term	Definition
Active Financial Year	The current operational year for financial reporting; set in System Settings.
Financial Year	A 12‑month period for accounting (e.g., July–June).
Regulating Leader	Leader who creates and oversees an event.
Appointed Chairperson	Leader designated to manage a specific event.
Spiritual Community	Members grouped by academic programme.
Spiritual Group	Devotional group (Choir, Legion, Charismatic).
Kamati	Committee (Liturgical, Decoration, Table of Sales).
Appendix D: Full Sidebar Menu by Role
The sidebar is collapsible, displays Financial Year Selector at the top (for roles with finance access), and shows only permitted menu items per role.

Common Elements (all logged‑in users):
Dashboard (role‑specific)

Profile (My Profile, Change Password, Logout)

Role‑Specific Menus:
Menu Item	Super Admin	Chaplain	Chairperson (Emp/Std)	Secretary	Treasurer	Spiritual Coordinator	Community/Group Leader	Kamati Head	Member	Event Chairperson*
Financial Year Selector	✅	✅	✅(view)	✅(view)	✅(view)	❌	❌	❌	❌	❌
Members	full	full	view/edit	full	view only	own class only	own comm/group	own committee	❌	own role
Finance	full	full	view reports	❌	full	❌	❌	TableSales only	my contributions	❌
Certificates	full	full	approve/gen	generate	❌	own class	own comm/group	❌	my certs	❌
Communication	full	full	broadcast	send	❌	own class	own comm/group	own committee	receive only	send reminders
Events	full	full	create/regulate	create	❌	create for class	create for comm/group	create for committee	view invited	manage own event
Elections	full	full	oversee	assist	❌	view	manage own	❌	vote	❌
Assets	full	full	view	view/update	❌	❌	view group	view committee	❌	❌
Shop	full	full	view reports	❌	view reports	❌	❌	TableSales only	browse	❌
Reports	full	full	full	generate	financial only	programme only	community/group only	committee only	personal	event report
Administration	full	limited	❌	❌	❌	❌	❌	❌	❌	❌
*Event Chairperson is a temporary role for a specific event. When active, they see an additional menu item: “📅 Manage [Event Name]” with sub‑options for tasks, attendance, and post‑event report.

Sidebar Layout Example (for Chaplain):

text
┌─────────────────────────────────────────────┐
│ 🏠  Dashboard                               │
├─────────────────────────────────────────────┤
│ 📅 Financial Year: ▼ 2026/2027 (Active)    │
│    ├─ 2025/2026 (Closed)                   │
│    └─ 2024/2025 (Closed)                   │
├─────────────────────────────────────────────┤
│ 👥  Members                                 │
│ 💰  Finance                                 │
│ 📜  Certificates                            │
│ 📧  Communication                           │
│ 📅  Events                                  │
│ 🗳️  Elections                              │
│ 🛠️  Assets                                 │
│ 🛒  Shop                                    │
│ 📊  Reports                                 │
│ ⚙️  Administration                         │
│ 👤  Profile                                 │
└─────────────────────────────────────────────┘
END OF SOFTWARE REQUIREMENTS SPECIFICATION

Document Approval

Role	Name	Signature	Date
Prepared	David Rashid Ngungila	___________	//2026
Prepared	Anna Pius Moshiro	___________	//2026
Supervisor	Dr. Shadrack Madila	___________	//2026
Chaplain	Rev. Fr. Dominic Kimboi	___________	//2026