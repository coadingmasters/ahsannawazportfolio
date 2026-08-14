<?php

/*
|--------------------------------------------------------------------------
| Profile figures
|--------------------------------------------------------------------------
| The numbers quoted across the site — hero, about page, stat strips.
|
| They live here so every page quotes the SAME figure. They used to be typed
| into each template, which is how the homepage came to claim 2 years and 10
| projects while the about page claimed 5 years and 50. Conflicting numbers
| read as invented, and search engines see the mismatch too.
|
| Counts that can be derived from real content (projects, skills) are not
| listed here — App\Support\SiteStats reads those from the database.
*/

return [

    'years_experience' => 2,

    'happy_clients' => 8,

    'client_satisfaction' => '99%',

    'support' => '24/7',

    // A freshly seeded site should not advertise "0 projects"; whichever is
    // larger, this floor or the real count, is what gets shown.
    'min_projects' => 10,

];
