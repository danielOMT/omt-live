<template x-if="details">
    <div>
        <div class="x-mb-4 x-text-red-600 x-text-xl">
            <strong>
                <span x-text="details.salutation"></span> 
                <span x-text="details.firstname"></span> 
                <span x-text="details.lastname"></span>
            </strong>
        </div>

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>E-Mail:</strong></div>
            <div x-text="details.email"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Telefonnummer:</strong></div>
            <div x-text="details.phone"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Geburtsdatum:</strong></div>
            <div x-text="details.birthdate ? formatDate(details.birthdate) : '-'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Straße + HausNr.:</strong></div>
            <div x-text="details.address"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Postleitzahl:</strong></div>
            <div x-text="details.zip"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Stadt:</strong></div>
            <div x-text="details.city"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Was ist Dein höchster Bildungsabschluss?:</strong></div>
            <div x-text="details.degree ? enums.degree[details.degree] : 'Es wurde keine Option ausgewählt'"></div>
        </div>
        
        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Fachbereich des höchsten Bildungsabschlusses:</strong></div>
            <div x-text="details.specialty ? enums.specialty[details.specialty] : 'Es wurde keine Option ausgewählt'"></div>
        </div>
        
        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Link zum LinkedIn-Profil:</strong></div>
            <div x-text="details.linkedin_url"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">
        
        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Hochgeladener Lebenslauf:</strong></div>
            <div>
                <template x-if="details.resume_file">
                    <a :href="`/admin/job-profiles/open-resume?id=${details.id}`" target="_blank" x-text="details.resume_filename"></a>
                </template>
            </div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Aktuelle Position/Jobbezeichnung:</strong></div>
            <div x-text="details.position"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Aktueller Bereich:</strong></div>
            <div x-text="details.marketing_area ? enums.marketing[details.marketing_area] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Aktuelle Branche:</strong></div>
            <div x-text="details.branch ? enums.branch[details.branch] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung Online Marketing:</strong></div>
            <div x-text="details.experience ? enums.experience[details.experience] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <!-- Experience details -->               
        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im Affiliate Marketing:</strong></div>
            <div x-text="details.experience_am ? enums.experience_detailed[details.experience_am] : 'Es wurde keine Option ausgewählt'"></div>
        </div>
        
        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im Content Marketing:</strong></div>
            <div x-text="details.experience_cm ? enums.experience_detailed[details.experience_cm] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im E-Mail-Marketing:</strong></div>
            <div x-text="details.experience_em ? enums.experience_detailed[details.experience_em] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im Google Ads:</strong></div>
            <div x-text="details.experience_ga ? enums.experience_detailed[details.experience_ga] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im Inbound Marketing:</strong></div>
            <div x-text="details.experience_im ? enums.experience_detailed[details.experience_im] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im Public Relations (PR):</strong></div>
            <div x-text="details.experience_pr ? enums.experience_detailed[details.experience_pr] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im SEO:</strong></div>
            <div x-text="details.experience_seo ? enums.experience_detailed[details.experience_seo] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im Social Media Marketing:</strong></div>
            <div x-text="details.experience_smm ? enums.experience_detailed[details.experience_smm] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im Video Marketing:</strong></div>
            <div x-text="details.experience_vm ? enums.experience_detailed[details.experience_vm] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Berufserfahrung im Webdesign:</strong></div>
            <div x-text="details.experience_wd ? enums.experience_detailed[details.experience_wd] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Welche Führungserfahrung hast Du?:</strong></div>
            <div x-text="details.leadership_experience ? enums.leadership_experience[details.leadership_experience] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>In welchen Branchen warst Du bzw. bist Du tätig?:</strong></div>
            <div>
                <template x-for="value in details.experience_industries">
                    <div x-text="enums.branch[value]"></div>
                </template>
            </div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">
        <!-- End Experience details -->

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Welche Tool-Kenntnisse hast Du und wie würdest Du sie bewerten?:</strong></div>
            <div x-text="details.tools_knowledge"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Sprachkenntnisse - Deutsch:</strong></div>
            <div x-text="details.german_level ? enums.language_level[details.german_level] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Sprachkenntnisse - Englisch:</strong></div>
            <div x-text="details.english_level ? enums.language_level[details.english_level] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Sprachkenntnisse - Französisch:</strong></div>
            <div x-text="details.french_level ? enums.language_level[details.french_level] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Sprachkenntnisse - Spanisch:</strong></div>
            <div x-text="details.spanish_level ? enums.language_level[details.spanish_level] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Wie würdest Du Deinen aktuellen Job-Status beschreiben?:</strong></div>
            <div x-text="details.job_status ? enums.job_status[details.job_status] : 'Es wurde keine Option ausgewählt'"></div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <!-- Job status options -->
        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Aus welchen Gründen denkst Du über einen neuen Job nach?:</strong></div>
            <div>
                <template x-for="value in details.job_change_reason">
                    <div x-text="enums.job_change_reason[value]"></div>
                </template>
            </div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>In welchen Online Marketing Bereichen sind Stellen für Dich von Interesse?:</strong></div>
            <div>
                <template x-for="value in details.marketing_area_interest">
                    <div x-text="enums.marketing[value]"></div>
                </template>
            </div>
        </div>

        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">
        <!-- End Job status options -->

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Aktuelles Jahresgehalt (Brutto):</strong></div>
            <div x-text="details.annual_salary ? enums.annual_salary[details.annual_salary] : 'Es wurde keine Option ausgewählt'"></div>
        </div>
        
        <hr class="x-mt-2 x-mb-2 x-border-t-0 x-border-b x-border-blue-300">

        <div class="x-flex">
            <div class="x-flex-45 x-pr-2"><strong>Kommentare:</strong></div>
            <div x-text="details.comment"></div>
        </div>
    </div>
</template>