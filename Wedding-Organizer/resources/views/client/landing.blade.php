<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedify - Your Dream Wedding Organizer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    @include('client.partials.styles')
</head>
<body>
    @include('client.partials.navigation')
    @include('client.partials.home')

    @include('client.partials.packages')

    @include('client.partials.about-us')

    @include('client.partials.contact-us')

    @include('client.partials.footer')
    @include('client.partials.scripts')
</body>
</html>