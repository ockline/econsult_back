# Resignation Management System Documentation

## Overview
The Resignation Management System (Exit Management) is a comprehensive solution for managing employee resignations, retirements, and terminations. It provides a systematic process for handling the full and final settlement of employees when they exit from an organization.

## System Requirements
- **Req ID**: ECMS.Req.001
- **Req Name**: RESIGNATION
- **Actors**: IR (Industrial Relations), HR (Human Resources)
- **Pre-Conditions**: Can be raised from misconduct module, incapacity, or initiated on demand

## Key Features

### 1. Resignation Details Management
- Employee information capture
- Department and job title details
- Contact information and postal address
- Resignation date and remarks
- Document attachments (resignation notice, form, letter)

### 2. Resignation Acceptance Process
- HR acceptance details
- Service period information
- Effective dates and signatures
- Certificate of service generation

### 3. Approval Workflow
- Multi-stage approval process
- HR review and recommendations
- Manager review and approval
- Final approval by HR Manager

### 4. Document Management
- File upload and storage
- Document versioning
- Download capabilities
- Signature management

## Backend Structure

### Models (app/Models/Exits/)
- `Resignation.php` - Main resignation model
- `ResignationAcceptance.php` - Acceptance details model
- `ResignationWorkflow.php` - Workflow tracking model
- `ResignationAttachment.php` - File attachments model

### Controllers (app/Http/Controllers/Exits/)
- `ResignationController.php` - Main resignation controller
- `ResignationWorkflowController.php` - Workflow management controller

### Repositories (app/Repositories/Exits/)
- `ResignationRepository.php` - Resignation business logic
- `ResignationWorkflowRepository.php` - Workflow business logic

## Database Structure

### Tables Created
1. **resignations** - Main resignation records
2. **resignation_acceptances** - Acceptance details
3. **resignation_workflows** - Workflow tracking
4. **resignation_attachments** - File attachments

### Key Fields
- Employee details (name, department, job title)
- Contact information (phone, postal address)
- Resignation date and remarks
- Status and stage tracking
- Workflow history
- File attachments

## API Endpoints

### Exit Management (Resignation)
- `GET /employees/exits/resignation/show_all_resignations` - List all resignations
- `GET /employees/exits/resignation/show_resignation/{id}` - Get resignation details
- `POST /employees/exits/resignation/add_resignation` - Create new resignation
- `POST /employees/exits/resignation/update_resignation/{id}` - Update resignation
- `POST /employees/exits/resignation/submit_resignation/{id}` - Submit for review
- `POST /employees/exits/resignation/create_acceptance/{id}` - Create acceptance
- `DELETE /employees/exits/resignation/delete_resignation/{id}` - Delete resignation

### Exit Management Workflow
- `POST /employees/exits/resignation/review_resignation` - HR review
- `POST /employees/exits/resignation/manager_review` - Manager review
- `POST /employees/exits/resignation/approve_resignation` - Approve resignation
- `POST /employees/exits/resignation/reject_resignation` - Reject resignation
- `POST /employees/exits/resignation/return_resignation` - Return for revision
- `GET /employees/exits/resignation/workflow_history/{id}` - Get workflow history

## Frontend Components

### 1. ResignationList.jsx
- Display all resignations in a table format
- Status and stage indicators
- Action buttons (View, Edit, Delete)
- Pagination and filtering

### 2. AddResignation.jsx
- Form for creating new resignations
- Employee selection dropdown
- File upload for documents
- Save and submit functionality

### 3. ViewResignation.jsx
- Detailed resignation information
- Workflow history timeline
- Document download links
- Acceptance creation modal

### 4. EditResignation.jsx
- Edit existing resignation details
- File replacement options
- Update and submit actions

### 5. ResignationWorkflowModal.jsx
- Workflow action forms
- Review and approval interfaces
- Comments and recommendations
- Status tracking

## Workflow Process

### 1. Initiation
- IR creates resignation record
- Employee details and documents uploaded
- Status: Draft

### 2. Submission
- Resignation submitted for review
- Status: Submitted, Stage: HR Review

### 3. HR Review
- HR reviews and adds recommendations
- Status: Under Review, Stage: Manager Review

### 4. Manager Review
- Department manager reviews and recommends
- Status: Under Review, Stage: Final Approval

### 5. Final Approval
- HR Manager approves or rejects
- Status: Approved/Rejected, Stage: Completed

### 6. Acceptance Creation
- HR creates acceptance letter
- Signatures and final details
- Certificate of service generated

## Business Rules

### Resignation Notice
- Minimum 28 days notice required
- Payment in lieu of notice allowed
- Must be addressed to HR with CC to Manager

### Document Requirements
- Resignation notice file (Required)
- Resignation form file (Required)
- Resignation letter file (Required)
- Certificate of service (Optional)

### File Upload Limits
- Maximum file size: 5MB
- Allowed formats: PDF, DOC, DOCX
- Signature files: PDF, JPG, JPEG, PNG

## Status Messages

| Message | Condition |
|---------|-----------|
| "Resignation Saved Successfully" | When saving process encounters no errors |
| "Assignment done Successfully" | When assignment process encounters no errors |
| "Resignation Submitted Successfully" | When submission process encounters no errors |
| "Resignation approval Successfully" | When approval process encounters no errors |
| "Sorry! Operation failed" | When process encounters errors |

## File Storage

### Directory Structure
```
public/
├── resignations/
│   └── {resignation_id}/
│       ├── resignation_notice_file
│       ├── resignation_form_file
│       ├── resignation_letter_file
│       ├── certificate_of_service_file
│       ├── hr_signature_file
│       └── employee_signature_file
```

## Security Features

### Authentication
- JWT token-based authentication
- Role-based access control
- API middleware protection

### File Security
- File type validation
- Size limit enforcement
- Secure file storage
- Access control

## Error Handling

### Validation
- Required field validation
- File format validation
- Date range validation
- Business rule enforcement

### Exception Handling
- Database transaction rollback
- Error logging
- User-friendly error messages
- Graceful failure handling

## Performance Considerations

### Database Optimization
- Indexed foreign keys
- Efficient queries
- Pagination support
- Soft deletes

### File Management
- Efficient file storage
- Optimized file serving
- Cleanup procedures
- Backup strategies

## Future Enhancements

### Potential Features
- Email notifications
- SMS alerts
- Mobile app support
- Advanced reporting
- Integration with payroll
- Exit interview forms
- Asset return tracking

### Technical Improvements
- Caching implementation
- API rate limiting
- Advanced search
- Bulk operations
- Export functionality
- Audit trail enhancement

## Deployment Notes

### Prerequisites
- Laravel 8+ framework
- PHP 7.4+
- MySQL database
- File storage permissions
- API authentication setup

### Installation Steps
1. Run database migrations
2. Configure file storage paths
3. Set up API routes
4. Deploy frontend components
5. Configure permissions
6. Test workflow processes

## Support and Maintenance

### Monitoring
- Error logging
- Performance metrics
- User activity tracking
- File storage monitoring

### Maintenance Tasks
- Regular database cleanup
- File storage optimization
- Security updates
- Performance tuning
- User training

## Conclusion

The Resignation Management System provides a comprehensive solution for managing employee exits with proper workflow, document management, and approval processes. It ensures compliance with business rules and provides a systematic approach to handling resignations, retirements, and terminations.

The system is designed to be scalable, secure, and user-friendly, with proper error handling and performance optimization. It integrates seamlessly with the existing employee management system and provides a complete exit management solution.
