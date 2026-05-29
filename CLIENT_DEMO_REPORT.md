# TimeNest System Overview
## Client Demo Report

---

## Executive Summary

TimeNest is a comprehensive workforce management platform designed to track employee attendance, manage work hours, monitor productivity, and streamline team invitations. This report explains how each major system works in simple, business-friendly terms.

---

---

# PART 1: ATTENDANCE SYSTEM

## What is Attendance Tracking?

The Attendance System automatically records when employees arrive at work, leave work, and how many hours they worked. It tracks this information daily and generates reports to ensure compliance with company policies.

## Key Components of Attendance

### 1. **Daily Attendance Record**
Every working day, the system creates a daily attendance record for each employee that includes:
- **Attendance Status**: What type of day it was (Present, Half Day, Absent, Leave, Holiday, Weekend, or Incomplete)
- **Compliance Status**: Whether the day meets company requirements (Compliant, Pending, Overdue, Escalated, or Payroll Risk)
- **Total Work Hours**: How many minutes the employee worked
- **Break Time**: How many minutes the employee took breaks
- **Late Minutes**: How many minutes past the scheduled start time they clocked in
- **Overtime**: How many extra minutes they worked beyond the required daily hours

### 2. **Clock-In & Clock-Out Sessions**
Each time an employee clocks in or out, the system records:
- **Exact Time**: When they clocked in/out (down to the second)
- **Location**: GPS coordinates, device ID, and IP address
- **Device Source**: Whether they clocked in from Mobile App, Web Portal, Admin Panel, or System Automation
- **GPS Accuracy**: How accurate the GPS reading was
- **Suspicious Flag**: If the system detects unusual patterns (like impossible location jumps)

### 3. **Daily Aggregation**
The system automatically calculates:
- Total time worked (sum of all clock-in to clock-out sessions)
- Break time between sessions
- Late arrival time (if clocked in after the scheduled start time)
- Overtime (time worked beyond the daily requirement)

---

## Attendance Modes: STRICT vs. FLEXIBLE

TimeNest offers **three different attendance modes** that define how the system evaluates and enforces attendance policies:

### **MODE 1: STRICT MODE**

**Purpose**: Maximum enforcement for regulated or shift-based work environments.

**How It Works**:
- **Mandatory Daily Attendance**: Employees must be present during specified hours
- **Fixed Shift Times**: There's a specific start time (e.g., 9:00 AM)
- **Late Tracking**: If an employee clocks in after the start time plus a grace period (typically 15 minutes), the system counts this as "late"
- **Late Penalties**: Multiple lates per month trigger progressive salary deductions
- **Minimum Daily Hours**: Employees must work exactly the required hours (typically 8 hours)
- **No Flexibility in Clock Times**: Employees must follow the exact shift schedule

**Example Scenario**:
- Company policy: Start at 9:00 AM, work 8 hours, grace period of 15 minutes
- Employee A clocks in at 9:05 AM → ✓ Present (within grace period)
- Employee B clocks in at 9:20 AM → ⚠️ Marked as Late (+20 minutes)
- Employee C clocks in at 10:00 AM → ✗ Severely late, may trigger escalation

**Penalties Applied**:
- 1st late in a month: No penalty
- 2nd late: 1% salary deduction
- 3rd late: 3% salary deduction
- 4th+ late: 5% salary deduction

**When Used**: Manufacturing plants, banks, government offices, healthcare facilities, retail stores

---

### **MODE 2: FLEXIBLE MODE** 

**Purpose**: Accommodates modern, flexible work arrangements.

**How It Works**:
- **Result-Oriented**: Focus is on hours worked, not when they work
- **No Fixed Start Times**: Employees can start anytime within a broad window (e.g., 8 AM - 11 AM)
- **No Late Tracking**: The system doesn't penalize late arrivals; only total hours matter
- **Work Hour Requirements**: Must still meet the daily hour requirement (typically 8 hours)
- **Multiple Sessions**: Employees can clock in/out multiple times per day
- **Shift Flexibility**: Employees can work from any location

**Example Scenario**:
- Company policy: Work 8 hours per day, can start between 8 AM - 11 AM
- Employee A: Starts at 10:00 AM, works 8 hours, clocks out at 6:00 PM → ✓ Present
- Employee B: Starts at 9:00 AM, works 7 hours, clocks out at 4:00 PM → ⚠️ Half Day (less than 8 hours)
- Employee C: Works from home with flexible schedule → ✓ Present (if they logged required 8 hours)

**No Penalties For**:
- Late arrival (as long as they work required hours)
- Flexible start times
- Taking breaks at different times

**When Used**: Tech companies, consulting firms, creative agencies, remote-first companies, knowledge work industries

---

### **MODE 3: HYBRID MODE**

**Purpose**: Combines the best of both strict and flexible approaches.

**How It Works**:
- **Flexible with Core Hours**: Employees have flexibility but must be present during "core hours"
- **Split Shift Support**: Core hours might be 10 AM - 3 PM (must be present), but can start/end flex times
- **Late Tracking Within Core Hours**: If they miss core hours, it's flagged as an issue
- **Mixed Penalties**: Some penalties for core hour violations, but flexible on total hours
- **Location Flexibility**: Can work from home on approved days, but must be at office on specified days

**Example Scenario**:
- Company policy: Core hours are 10 AM - 3 PM, total 8 hours required
- Employee A: Clocks in 9:00 AM, leaves at 5:00 PM → ✓ Present (covers core hours + 8 total)
- Employee B: Clocks in 11:00 AM, leaves at 7:00 PM → ⚠️ Partial compliance (works 8 hours but misses 1 hour of core)
- Employee C: Starts at 3:30 PM → ✗ Major issue (missed entire core hours window)

**When Used**: Hybrid workplaces, companies with both office and remote teams, industries needing both structure and flexibility

---

## How Daily Status is Determined

### **Attendance Status Types**:

| Status | Meaning | When It Happens |
|--------|---------|-----------------|
| **Present** | Full day worked | Worked ≥ required hours (typically 8 hours) |
| **Half Day** | Partial work | Worked between 50%-99% of required hours |
| **Absent** | No work done | Worked < 50% of required hours AND not on leave |
| **Leave** | Approved absence | Employee has approved leave (Casual, Sick, Personal, etc.) |
| **Holiday** | Company closure | Day is marked as company holiday (weekends, national holidays) |
| **Weekend** | Non-working day | Saturday/Sunday or declared non-working day |
| **Incomplete** | Still working | Employee clocked in but hasn't clocked out yet (today only) |

### **Compliance Status Types**:

| Status | Meaning | Impact |
|--------|---------|--------|
| **Compliant** | Meets all requirements | ✓ No action needed, contributes to attendance records |
| **Pending** | Awaiting review | ⏳ Employee marked as present but system needs verification |
| **Overdue** | Missed deadline | ⚠️ Employee didn't attend without approved leave - escalation flag |
| **Escalated** | Needs attention | 🔴 Multiple overdue/absent days - manager intervention needed |
| **Payroll Risk** | Serious concern | 🔴🔴 Employee's attendance threatens payroll compliance or certification |

---

## Special Attendance Features

### **Extra Working Days (EWD)**
Allows employees to work on holidays or weekends if approved:
- Employee can request to work on a holiday
- If approved, system allows clock-in on that day
- Counts as regular working day
- Can be used to accumulate compensatory days off

### **Work From Home (WFH)**
Allows employees to work remotely without location verification:
- Employee requests to work from home for specific date(s)
- If approved, GPS location check is bypassed
- System still tracks clock-in/out and hours worked
- Counts as regular attendance day

### **Holidays**
System recognizes and auto-marks company holidays:
- National holidays (automatically configured)
- Company holidays (company-specific days)
- Regional holidays (branch/location specific)
- Employees don't need to clock in on declared holidays
- Counts as "Holiday" status automatically

### **Geofencing**
GPS-based location verification:
- Each office location has a defined geographical boundary (typically 200 meters radius)
- Employees must clock in within this boundary (unless WFH is approved)
- System can detect suspicious clock-ins from impossible locations
- Example: Employee tries to clock in from a different city than expected → Flagged as suspicious

---

## Attendance Adjustments

Employees can request corrections to their attendance records:

### **Types of Adjustments**:
1. **Clock-In Correction**: "I clocked in late because the app crashed"
2. **Clock-Out Correction**: "I forgot to clock out; I actually left at 6 PM"
3. **Session Deletion**: "I clocked in by mistake; please delete this session"
4. **Manual Attendance Entry**: "The system wasn't working that day; please manually mark me present"

### **Adjustment Workflow**:
1. Employee submits adjustment request with reason/proof
2. Manager reviews the request
3. Manager approves or rejects (with reason)
4. Once approved, daily aggregates are recalculated
5. Full audit trail is maintained (who changed what, when, why)

---

---

# PART 2: TIMELOGS / WORKLOG SYSTEM

## What is Timelog/Worklog Tracking?

While Attendance tracks **when and where** employees work, Timelogs track **what they work on**. Timelogs are detailed records of time spent on specific projects, milestones, and tasks.

## Key Components of Timelogs

### 1. **Worklog Entry**
Each worklog record contains:
- **Time Period**: Start time and end time (or total minutes worked)
- **Project Assignment**: Which project this time is being logged against
- **Milestone**: Which milestone/phase of the project
- **Task**: Which specific task or work item
- **Description**: What work was done during this time
- **Status**: Draft, Submitted, Approved, Rejected, or Locked
- **Minutes Logged**: How many minutes were spent
- **Compliance Status**: Whether this worklog meets policy requirements

### 2. **Task Time Consumption**
The system tracks how much time has been consumed on each task:
- **Estimated Time**: How long the task was supposed to take (e.g., 10 hours)
- **Consumed Time**: How much time has actually been logged against it
- **Overflow Detection**: If more time is logged than estimated, system flags it
- **Overflow Justification**: Employee can provide reason for exceeding estimate

### 3. **Worklog Lifecycle**
Each worklog goes through a workflow:

```
Draft 
  ↓ (Employee submits)
Submitted 
  ↓ (Manager reviews)
Approved / Rejected
  ↓ (After approval grace period)
Locked (Cannot be edited)
```

---

## Timelog Modes: STRICT vs. FLEXIBLE

TimeNest offers two different worklog policy modes for managing how time is logged:

### **MODE 1: STRICT WORKLOG MODE**

**Purpose**: Precise project tracking with rigorous accountability.

**How It Works**:
- **Mandatory Worklog Submission**: Employees MUST log work time immediately or very soon after clocking out
- **Immediate Submission Window**: Work logs must be submitted within a specific time (typically same day or next business day)
- **Project Mapping Required**: Every worklog MUST be linked to a project
- **Task Mapping Required**: Every worklog MUST be linked to a specific task
- **Overflow Blocking**: Cannot exceed task estimated time without manager approval
- **No Deferred Submission**: Cannot delay worklog submission beyond the window
- **Automatic Escalation**: Overdue logs (not submitted within window) are automatically escalated to manager
- **Edit Restrictions**: Once submitted, minimal editing allowed (can only edit within grace period, typically 1 day)
- **Lock Enforcement**: After 3 days, worklog is locked and cannot be edited at all

**Example Scenario**:
- Strict Policy: Must submit worklog within 4 hours of clocking out
- Employee A: Clocks out at 5:00 PM → Must submit worklog by 9:00 PM ✓
- Employee B: Clocks out at 5:00 PM → Submits at 10:00 PM → ✗ Late, escalated to manager
- Employee C: Clocks out at 5:00 PM → Submits worklog logging 12 hours on a 10-hour task → ✗ Requires justification

**What's Required**:
- Project must be selected
- Task must be selected (not optional)
- Time spent must not exceed task estimate (or provide justification)
- Description of work is mandatory
- Submission cannot be delayed

**When Used**: Client billable work, regulated industries, fixed-price projects, client-facing delivery teams

**Benefits**:
- Accurate time tracking for billing clients
- Real-time visibility into project progress
- Early identification of scope overflow
- Compliance with client contracts

---

### **MODE 2: FLEXIBLE WORKLOG MODE**

**Purpose**: Accommodates knowledge work and allows asynchronous logging.

**How It Works**:
- **Deferred Submission Allowed**: Employees can submit logs several days or weeks later (typically up to 2 weeks)
- **Optional Project Mapping**: Project assignment is not mandatory if not applicable
- **Optional Task Mapping**: Task assignment is optional for general work
- **Overflow Warnings**: If time exceeds task estimate, system warns but doesn't block submission
- **Justification Optional**: Can add justification for overflow but not required
- **Flexible Deadlines**: Worklogs can be edited for longer (typically up to 7 days after submission)
- **Manual Time Input**: Can manually enter time instead of using automated clock-in/out
- **No Automatic Escalation**: System doesn't automatically escalate overdue logs (but manager can manually)
- **Multiple Worklogs Per Session**: One clock-in/out session can have multiple worklog entries

**Example Scenario**:
- Flexible Policy: Can submit worklog up to 2 weeks later, projects optional
- Employee A: Clocks out at 5:00 PM → Submits worklog Friday EOD for Tuesday's work ✓
- Employee B: Works on multiple projects → Submits one combined worklog ✓
- Employee C: Logs time on task estimated at 10 hours, actual logged is 14 hours → System warns but accepts with note ✓
- Employee D: Realizes Monday they forgot to log Thursday's work → Can still submit with retroactive date ✓

**What's Optional**:
- Project selection can be skipped
- Task selection can be skipped
- Deferred submission up to 2 weeks
- Overflow justification
- Can edit submitted logs for longer period

**When Used**: R&D teams, internal projects, support teams, maintenance work, continuous improvement initiatives

**Benefits**:
- Flexibility for knowledge workers
- Reduced administrative burden
- Accommodates async work patterns
- Focuses on outcomes, not precision

---

## Hybrid Worklog Approach

Some companies use both modes for different types of work:

| Project Type | Client Billable Work | Internal Project | Support & Maintenance |
|--------------|---------------------|------------------|----------------------|
| **Mode** | Strict | Flexible | Flexible |
| **Project Required** | Yes | No | No |
| **Task Required** | Yes | Optional | Optional |
| **Submission Window** | Same day | 2 weeks | 2 weeks |
| **Overflow Handling** | Must justify | Auto-accept | Auto-accept |

---

## Worklog Compliance & Overflow

### **What is Overflow?**
When an employee logs more time on a task than the task's estimated duration:

**Example**:
- Task "Build Dashboard" estimated at 16 hours
- Employee logs 20 hours on this task
- 4 hours of "overflow"

### **How System Handles Overflow**:

**In Strict Mode**:
- System **blocks** submission if overflow detected
- Requires employee to provide justification
- Manager must approve before accepting the worklog
- Justification is recorded in the system

**In Flexible Mode**:
- System **warns** about overflow
- Allows submission anyway
- Records the overflow flag for reporting
- No explicit approval required, but visible to managers

### **Common Overflow Reasons**:
- "Unexpected complexity discovered during implementation"
- "Had to refactor due to technical debt"
- "Third-party API integration took longer"
- "Additional testing and bug fixes required"

---

## Worklog Statuses

| Status | Owner | What Happens | Next Step |
|--------|-------|--------------|-----------|
| **Draft** | Employee | Being prepared, not submitted | Employee submits for approval |
| **Submitted** | Employee/Manager | Awaiting manager review | Manager reviews and approves/rejects |
| **Approved** | Manager | Accepted, counts toward project tracking | Auto-locks after grace period |
| **Rejected** | Manager | Sent back for correction | Employee must resubmit |
| **Locked** | System | Cannot be edited anymore | Can only be viewed, used for reporting |
| **Escalated** | System | Flagged because overdue or needs attention | Manager resolves manually |

---

## Worklog Features

### **Multiple Worklogs Per Session**
One clock-in/out session can be split into multiple worklogs:

**Scenario**:
- Employee clocks in at 9 AM, clocks out at 5 PM (8 hours)
- Logs 3 hours on "Client Project A"
- Logs 2 hours on "Internal Meeting"
- Logs 3 hours on "Code Review & Support"
- Total = 8 hours

### **Automatic Time Consumption Tracking**
System automatically tracks:
- Total time logged on each task
- Percentage of estimated time used
- Projected overrun
- Time remaining (if not overrun)

### **Task Overflow Justification**
When employee exceeds task estimate, they can add context:
- What changed during execution
- Why estimate was incorrect
- What was learned for future estimates
- Any dependencies or blockers

---

---

# PART 3: INVITATION FLOW SYSTEM

## What is the Invitation System?

The Invitation System is a secure, workflow-based process for bringing new people into the organization. It manages invitations from creation to acceptance and provides audit trails.

## Key Components of Invitations

### 1. **Invitation Record**
Each invitation contains:
- **Invitee Email**: The person being invited
- **Inviter**: Who sent the invitation
- **Company/Organization**: Which organization they're being invited to
- **Role**: What role they'll have (Employee, Manager, Admin, etc.)
- **Status**: Current state of the invitation (Pending, Accepted, Expired, Revoked)
- **Invitation Link**: Unique secure link for the invitee to accept
- **Expiration Date**: When the invitation expires (typically 30 days)
- **Created At**: When the invitation was sent
- **Accepted At**: When (if) the invitation was accepted
- **Revoked At**: When (if) the invitation was cancelled

### 2. **Status Tracking**
System maintains full history of invitation lifecycle:
- When created
- When sent
- When viewed/opened
- When accepted or rejected
- When expired
- When revoked

---

## Invitation Workflow: Step-by-Step Process

### **STEP 1: ADMIN CREATES INVITATION**

**Who Can Do This**: Company Administrator or HR Manager

**Process**:
1. Admin logs into TimeNest
2. Goes to "Invite Team Member" section
3. Enters the new person's email address
4. Selects their role (Employee, Manager, Admin, etc.)
5. Optionally adds personal message
6. Clicks "Send Invitation"

**What System Does**:
- Creates an invitation record
- Generates a unique invitation link
- Sets expiration date (default: 30 days from now)
- Marks status as "Pending"
- Logs this action in audit trail

**Example**:
- Admin invites: john.doe@gmail.com
- Role: Employee
- Company: Acme Corp
- Invitation expires: 30 days from today

---

### **STEP 2: INVITATION EMAIL SENT**

**What Happens**:
- System sends professional email to the invitee's email address
- Email includes:
  - Company name
  - Inviter's name
  - The role they're being offered
  - Personalized message (if admin added one)
  - **Unique Invitation Link** (most important)
  - Expiration date warning
  - Company logo and branding

**Email Example**:
```
Subject: Join Acme Corp on TimeNest

Hi John,

You've been invited by Sarah (HR Manager) to join Acme Corp 
as an Employee.

Click below to accept your invitation:
https://timenest.com/invite/abc123def456xyz789

This invitation expires on June 15, 2026.

[Company Logo]
```

---

### **STEP 3: INVITEE CLICKS INVITATION LINK**

**What Happens**:
- Invitee clicks the link from email
- System verifies the link is valid and not expired
- If valid → Shows acceptance page
- If expired → Shows "Invitation Expired" message
- If already used → Shows "Already Accepted" message
- If revoked → Shows "Invitation Revoked" message

**Verification Checks**:
- ✓ Link exists in system
- ✓ Link not expired (within 30 days)
- ✓ Link not already used
- ✓ Link not revoked by admin
- ✓ Invitation status is still "Pending"

---

### **STEP 4: INVITEE ACCOUNT CREATION**

**What Invitee Sees**:
- Pre-filled email field (can be changed)
- First name field
- Last name field
- Password creation field
- Terms & Conditions checkbox
- "Create Account & Join" button

**What System Does**:
- Validates all fields are complete
- Checks if email already exists in system
  - If yes → Asks to log in instead
  - If no → Creates new user account
- Links this account to the company
- Assigns the specified role
- Sets profile as active

**Security**:
- Password requirements enforced (minimum 12 characters, mix of uppercase, numbers, symbols)
- Email verification sent
- Account flagged as newly joined (onboarding reminders sent)

---

### **STEP 5: INVITATION ACCEPTED**

**What Changes**:
- Invitation status changes from "Pending" to "Accepted"
- "Accepted At" timestamp recorded
- User account is fully activated
- System sends confirmation email to inviter

**User Can Now**:
- Log into TimeNest
- Clock in/out (track attendance)
- Submit timesheets
- Request leaves
- View company policies
- Access role-specific features

**What Happens Next**:
- Welcome email sent with getting started instructions
- Onboarding checklist sent
- Notifications sent to team leads/managers
- Employee records are created
- Branch assignment (if applicable) is set up

---

## Alternative Invitation Outcomes

### **SCENARIO 1: INVITATION EXPIRES**

**Timeline**: 30 days after creation

**What Happens**:
- Invitation link stops working
- Status changes to "Expired"
- Invitee gets notification: "Your invitation has expired"
- Admin receives notification: "Invitation to john.doe@gmail.com expired"

**What Admin Can Do**:
- Send a new invitation to same email
- Archive the expired invitation
- Follow up directly with invitee

---

### **SCENARIO 2: ADMIN REVOKES INVITATION**

**When This Happens**:
- Admin decides not to proceed with hiring
- Person didn't respond and won't be joining
- Admin made a mistake with the email

**What Admin Does**:
- Finds the pending invitation
- Clicks "Revoke Invitation"
- System marks it as "Revoked"
- Invitee's link stops working immediately

**What Happens**:
- Invitee sees: "This invitation has been revoked"
- Audit log records: who revoked it, when, reason
- Admin can optionally send follow-up email explaining

---

### **SCENARIO 3: INVITEE ALREADY HAS ACCOUNT**

**What Happens**:
- Person already registered in TimeNest for a different company
- Invitee uses that existing account to log in
- System automatically adds them to the new company
- Old role remains, new role is added
- They now have access to both companies

**Example**:
- Sarah is an Employee at CompanyA
- Sarah gets invited to CompanyB as Manager
- After accepting, Sarah can:
  - Log into CompanyA as Employee
  - Switch to CompanyB and work as Manager
  - See data/records for both companies (based on permissions)

---

### **SCENARIO 4: WRONG EMAIL**

**What Happens**:
- Admin sent invitation to wrong email by mistake
- Person at that email address accepts
- System creates account for them (not the intended person)

**Resolution**:
- Admin must revoke the invitation immediately
- Delete the incorrectly created account (if possible)
- Send new invitation to correct email
- System maintains audit log of the mistake

---

## Invitation Security Features

### **Link Security**:
- Each invitation link is unique and cryptographically secure
- Link cannot be guessed or brute-forced
- Link expires after 30 days (configurable)
- Link is single-use (works only once)
- System logs every link access attempt

### **Email Verification**:
- Email must be valid format
- System can optionally verify domain ownership
- Multiple invitations to same email possible but tracked

### **Account Protection**:
- Password requirements enforced
- Two-factor authentication can be enabled
- Account flagged as new (receives security notifications)
- Activity monitoring on new accounts

### **Audit Trail**:
- Every action logged:
  - Who created the invitation
  - When it was created
  - Who clicked the link
  - When invitation was accepted
  - Which account was created
  - Any revocations or changes
- Full compliance and security audit available

---

## Bulk Invitations

For hiring multiple people, admin can:

**Bulk Upload**:
1. Prepare CSV file with email addresses and roles
2. Upload file to system
3. System validates all emails
4. Create confirmation showing how many invitations will be sent
5. Send all at once

**System Sends**:
- Individual email to each person
- Each email personalized with their name/role
- All tracked separately
- Can monitor acceptance status for all

**Example CSV**:
```
email,role,first_name_hint,department
alice@example.com,Employee,Alice,Engineering
bob@example.com,Manager,Bob,Sales
carol@example.com,Employee,Carol,HR
```

---

## Permission-Based Invitations

### **Who Can Send Invitations?**
- **Company Admin**: Can invite anyone in any role
- **HR Manager**: Can typically invite Employees and limited roles
- **Team Lead**: Usually cannot send invitations (depends on company policy)

### **Who Can Accept Invitations?**
- Anyone with a valid email address
- Anyone who hasn't already been invited with that email
- Anyone with a valid TimeNest account (can join multiple companies)

### **What Roles Can Be Assigned?**
- **Employee**: Standard worker, can track attendance and timesheets
- **Manager**: Employee + can approve leaves, reviews, manage team
- **Admin**: Full access to company settings and all features
- **HR**: Can manage employees, leaves, policies
- **Viewer**: Read-only access to reports (no data entry)

---

## Invitation Notifications

### **Email Notifications Sent**:
1. **Invitation Email** (to invitee): Invitation link and details
2. **Acceptance Confirmation** (to inviter): Person accepted
3. **Expiration Reminder** (to invitee): 3 days before expiry
4. **Revocation Notification** (to invitee, if revoked): Invitation cancelled
5. **Onboarding Email** (to invitee): Getting started guide after joining

### **In-App Notifications**:
- Admin sees pending invitations dashboard
- Can see acceptance rates and pending invites
- Reminders for expired unaccepted invitations
- Activity feed shows who joined recently

---

## Common Invitation Scenarios

### **Scenario A: New Hire Joining**
```
Monday 9 AM: Admin sends invitation
Monday 10 AM: HR sends follow-up with system access info
Tuesday 2 PM: Candidate clicks link, creates account
Tuesday 2:15 PM: Candidate appears in company roster
Tuesday 3 PM: Manager assigns to team & branch
Wednesday 9 AM: Candidate clocks in for first day
```

### **Scenario B: Mass Onboarding**
```
Friday: HR uploads 50 employee CSV files
Friday 2 PM: System sends 50 invitations
Weekend: Employees receive emails, start clicking
Monday: 35 have joined, HR follows up with 15 who haven't
Tuesday: 48 have joined, 2 invalid emails bounced
Wednesday: All 48 verified and assigned to teams
```

### **Scenario C: Invitation Issues**
```
10:00 AM: Admin invites wrong email (typo)
10:15 AM: Wrong person receives invite, gets suspicious
10:30 AM: Admin notices mistake, revokes
10:32 AM: Wrong person's link stops working
10:35 AM: Admin sends correct invitation
11:00 AM: Correct person receives invitation
```

---

---

## Summary Comparison Table

| Aspect | Attendance System | Timelog System | Invitation System |
|--------|------------------|----------------|-------------------|
| **Purpose** | Track when employees work | Track what employees work on | Bring people into company |
| **Key Data** | Clock-in/out times, hours | Projects, tasks, time spent | Email, role, acceptance |
| **Strict Mode** | Fixed shifts, late penalties | Mandatory submission, project required | N/A |
| **Flexible Mode** | Any time, result-focused | Optional submission, projects optional | N/A |
| **Automated** | Clock-in/out, recalculation | Time consumption tracking | Email sending, expiration |
| **Manual Review** | Adjustments, approvals | Overflow justification, status changes | Revocation, resending |
| **Status Types** | Present/Absent/HalfDay | Draft/Submitted/Approved/Locked | Pending/Accepted/Expired/Revoked |
| **Duration** | Daily | Per work session | Until accepted or expired |
| **Compliance Focus** | Attendance compliance | Project accuracy & billability | Security & onboarding |

---

## Key Takeaways for Your Business

### **Attendance System Benefits**:
✓ Know exactly when employees are working
✓ Ensure compliance with company policies
✓ Reduce time theft and unauthorized absences
✓ Support flexible and strict work arrangements
✓ Maintain audit trails for HR/payroll

### **Timelog System Benefits**:
✓ Track productivity and project progress
✓ Identify scope creep and overruns early
✓ Enable accurate client billing
✓ Improve project estimation accuracy
✓ Maintain task-level visibility into work

### **Invitation System Benefits**:
✓ Secure and professional onboarding
✓ Track who joins and when
✓ Manage role assignments from day one
✓ Compliance with company policies
✓ Easy team scaling and hiring

---

## Customization Options

All three systems can be customized to match your company's needs:

- **Attendance**: Shift times, grace periods, late penalties, geofence radius, modes
- **Timelogs**: Submission windows, project requirements, overflow handling, edit periods
- **Invitations**: Expiration times, role options, message templates, bulk upload limits

Contact your TimeNest account manager to customize these systems for your organization.

---

**End of Report**
