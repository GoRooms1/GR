# New email from contact form

Content of email form:

- Name of user: {{ $feedbackData->name }}
- User Email: {{ $feedbackData->email }}
- User Phone: {{ $feedbackData->phone }}
- Message: {{ $feedbackData->message }}

Thanks,<br>
{{ config('app.name') }}
