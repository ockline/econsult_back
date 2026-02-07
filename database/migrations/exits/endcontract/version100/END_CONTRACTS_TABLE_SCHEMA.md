# End Contracts Table Schema

## Table Name: `end_contracts`

This table stores all exit-related data for employees, including end of contracts (Fixed Term and Specific Task), resignations, retrenchments, and mutual agreements.

## Columns

### Primary Key
- `id` (bigint, unsigned, auto-increment) - Primary key

### Employee Information
- `employee_id` (bigint, unsigned, NOT NULL) - Foreign key to `employees.id`
- `employee_name` (string, NOT NULL) - Full name of the employee
- `department_name` (string, NOT NULL) - Department name
- `job_title` (string, NOT NULL) - Job title
- `postal_address` (text, NOT NULL) - Postal address
- `phone_number` (string, NOT NULL) - Phone number

### Exit Type Classification
- `exit_type` (enum, default: 'end_contract') - Type of exit:
  - `'end_contract'` - Fixed Term Contract End
  - `'end_specific_contract'` - Specific Task Contract End
  - `'resignation'` - Employee Resignation
  - `'retrenchment'` - Retrenchment
  - `'mutual_agreement'` - Mutual Agreement
- `contract_type_id` (bigint, unsigned, nullable) - Foreign key to `contracts.id`:
  - `1` = Fixed Term Contract
  - `2` = Specific Task Contract

### Exit Details
- `remark` (text, NOT NULL) - Remarks/notes
- `end_date` (date, NOT NULL) - End date of contract/employment

### Documents
- `renewal_notice_file` (string, nullable) - Renewal notice document file path

### Employment Contract Details (Optional)
- `employer_name` (string, nullable) - Employer name
- `letter_title` (string, nullable) - Letter title
- `signed_date` (date, nullable) - Date contract was signed
- `started_date` (date, nullable) - Employment start date
- `days_worked` (integer, nullable) - Number of days worked (auto-calculated)
- `on_behalf_of` (string, nullable) - On behalf of
- `designation` (string, nullable) - Designation
- `hr_name` (string, nullable) - HR representative name
- `employee_designation` (string, nullable) - Employee designation

### Signatures
- `signature_file` (string, nullable) - HR signature file path (image only)
- `employee_signature_file` (string, nullable) - Employee signature file path (image only)

### Non-Renewal Contract Details (Optional)
- `job_department` (string, nullable) - Job department
- `contract_date` (date, nullable) - Original contract date
- `expire_date` (date, nullable) - Contract expiration date
- `non_renewal_letter_title` (string, nullable) - Non-renewal letter title

### Status and Workflow
- `status` (enum, default: 'Draft') - Current status:
  - `'Draft'` - Draft status
  - `'Submitted'` - Submitted for review
  - `'Under Review'` - Under review
  - `'Approved'` - Approved
  - `'Rejected'` - Rejected
  - `'Completed'` - Completed
- `stage` (enum, default: 'Initiated') - Current workflow stage:
  - `'Initiated'` - Just initiated
  - `'HR Review'` - Under HR review
  - `'Manager Review'` - Under manager review
  - `'Final Approval'` - Awaiting final approval
  - `'Completed'` - Completed
- `hr_recommendations` (text, nullable) - HR recommendations
- `manager_recommendations` (text, nullable) - Manager recommendations

### Audit Fields
- `created_by` (bigint, unsigned, nullable) - Foreign key to `users.id` (user who created)
- `updated_by` (bigint, unsigned, nullable) - Foreign key to `users.id` (user who last updated)
- `created_at` (timestamp, nullable) - Creation timestamp
- `updated_at` (timestamp, nullable) - Last update timestamp
- `deleted_at` (timestamp, nullable) - Soft delete timestamp

## Foreign Keys

1. `employee_id` → `employees.id` (CASCADE on delete)
2. `created_by` → `users.id` (SET NULL on delete)
3. `updated_by` → `users.id` (SET NULL on delete)
4. `contract_type_id` → `contracts.id` (nullable, no constraint)

## Indexes

- Primary key index on `id`
- Index on `exit_type`
- Index on `contract_type_id`
- Foreign key indexes on `employee_id`, `created_by`, `updated_by`

## Related Tables

- `end_contract_workflows` - Stores workflow history for each end contract
- `employees` - Employee information
- `users` - User information (for created_by/updated_by)
- `contracts` - Contract types (for contract_type_id)
- `contract_details` - Contract details (for joining to get contract type)

## Usage

### Creating End Specific Contract
When creating an end specific contract:
- `exit_type` = `'end_specific_contract'`
- `contract_type_id` = `2`
- All other fields as per form data

### Creating End Fixed Contract
When creating an end fixed contract:
- `exit_type` = `'end_contract'`
- `contract_type_id` = `1`
- All other fields as per form data

### Querying by Exit Type
```sql
-- Get all end specific contracts
SELECT * FROM end_contracts WHERE exit_type = 'end_specific_contract';

-- Get all end contracts (fixed term)
SELECT * FROM end_contracts WHERE exit_type = 'end_contract';
```

