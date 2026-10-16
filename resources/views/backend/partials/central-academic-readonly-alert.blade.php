@if (hasModule('MultiBranch') && ! canManageCentralAcademicSetup())
    <div class="alert alert-info mb-3" role="alert">
        <i class="fa-solid fa-circle-info me-2"></i>
        Academic setup is managed centrally by the Super Admin and shared with all branches. You can view and use these
        records when managing students, routines, and other branch operations.
    </div>
@endif
