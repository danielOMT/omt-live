<?php

use OMT\Enum\AnnualSalary;
use OMT\Enum\Branch;
use OMT\Enum\Degree;
use OMT\Enum\Experience;
use OMT\Enum\ExperienceDetailed;
use OMT\Enum\JobChangeReason;
use OMT\Enum\JobStatus;
use OMT\Enum\LanguageLevel;
use OMT\Enum\LeadershipExperience;
use OMT\Enum\Magazines;
use OMT\Enum\Specialty;
use OMT\Services\Date;

?>
<div class="um-account-main x-absolute profile-resume-tab" id="profile-resume-tab">
    <div class="um-account-tab um-account-tab-resume" data-tab="resume">
        <div
            x-data="xJobProfile()"
            x-init="initialize()"
            class="x-mt-4 profile-resume-section"
        >
            <div x-ref="alertContainer" class="x-w-full">
                <div 
                    x-cloak 
                    x-show="message" 
                    class="x-text-left x-mb-4 x-pl-2 x-pr-2 x-pt-2 x-pb-2 x-rounded x-items-center x-shadow x-flex"
                    :class="noticeType == 'error' ? 'x-text-red-600 x-bg-red-50' : 'x-text-green-600 x-bg-green-50'"
                >
                    <div class="x-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="x-fill-current x-w-5" viewBox="0 0 24 24">
                            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"/>
                        </svg>
                    </div>

                    <div
                        x-text="message"
                        class="x-flex-1 x-ml-4"
                        :class="noticeType == 'error' ? 'x-text-red-800' : 'x-text-green-800'"
                    ></div>
                </div>
            </div>

            <form 
                method="POST" 
                action="/account/resume/" 
                name="lebenslauf_eingereicht" 
                id="lebenslauf_eingereicht"
                @submit.prevent="update()"
            >
                <div class="x-pb-4">
                    <label for="salutation">Anrede <span class="x-text-red-600">*</span></label>
                    <input type="text" id="salutation" name="salutation" x-model="form.salutation" x-init="watcher('salutation')" required="required">
                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('salutation')" 
                        x-html="form.errors.get('salutation')"            
                    ></div>
                </div>

                <div class="x-flex x-pb-4">
                    <div class="x-box-border x-flex-50 x-pr-2">
                        <label for="firstname">Vorname <span class="x-text-red-600">*</span></label>
                        <input type="text" id="firstname" name="firstname" x-model="form.firstname" x-init="watcher('firstname')" required="required">
                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('firstname')" 
                            x-html="form.errors.get('firstname')"            
                        ></div>
                    </div>
                    <div class="x-box-border x-flex-50 x-pl-2">
                        <label for="lastname">Nachname <span class="x-text-red-600">*</span></label>
                        <input type="text" id="lastname" name="lastname" x-model="form.lastname" x-init="watcher('lastname')" required="required">
                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('lastname')" 
                            x-html="form.errors.get('lastname')"            
                        ></div>
                    </div>
                </div>

                <div class="x-flex x-pb-4">
                    <div class="x-flex-auto x-pr-2">
                        <label for="email">E-Mail <span class="x-text-red-600">*</span></label>
                        <input type="email" id="email" name="email" x-model="form.email" x-init="watcher('email')" required="required">
                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('email')" 
                            x-html="form.errors.get('email')"            
                        ></div>
                    </div>
                    <div class="x-flex-auto x-pr-2 x-pl-2">
                        <label for="phone">Telefonnummer <span class="x-text-red-600">*</span></label>
                        <input type="tel" id="phone" name="phone" x-model="form.phone" x-init="watcher('phone')" required="required">
                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('phone')" 
                            x-html="form.errors.get('phone')"            
                        ></div>
                    </div>
                    <div class="x-flex-auto x-pl-2 omt-form-group">
                        <label for="birthdate">Geburtsdatum <span class="x-text-red-600">*</span></label>

                        <input 
                            type="date" 
                            max="<?php echo Date::get()->format('Y-m-d') ?>"
                            id="birthdate" 
                            name="geburtsdatum" 
                            x-model="form.birthdate" 
                            x-init="watcher('birthdate')" 
                            required="required" 
                            class="input x-w-full"
                        >
                        
                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('birthdate')" 
                            x-html="form.errors.get('birthdate')"            
                        ></div>
                    </div>
                </div>

                <div class="x-flex x-pb-4">
                    <div class="x-flex-auto x-pr-2">
                        <label for="address">Straße + HausNr. <span class="x-text-red-600">*</span></label>
                        <input type="text" id="address" name="address" x-model="form.address" x-init="watcher('address')" required="required">
                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('address')" 
                            x-html="form.errors.get('address')"            
                        ></div>
                    </div>
                    <div class="x-flex-auto x-pr-2 x-pl-2">
                        <label for="zip">Postleitzahl <span class="x-text-red-600">*</span></label>
                        <input type="text" id="zip" name="zip" x-model="form.zip" x-init="watcher('zip')" required="required">
                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('zip')" 
                            x-html="form.errors.get('zip')"            
                        ></div>
                    </div>
                    <div class="x-flex-auto x-pl-2">
                        <label for="city">Stadt <span class="x-text-red-600">*</span></label>
                        <input type="text" id="city" name="city" x-model="form.city" x-init="watcher('city')" required="required">
                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('city')" 
                            x-html="form.errors.get('city')"            
                        ></div>
                    </div>
                </div>

                <div class="x-flex x-pb-4">
                    <div class="x-box-border x-flex-50 x-pr-2 omt-form-group">
                        <label for="degree">Was ist Dein höchster Bildungsabschluss? <span class="x-text-red-600">*</span></label>

                        <select id="degree" name="jobs_hochster_bildungsabschluss" x-model="form.degree" x-init="watcher('degree')" class="dropdown" required="required">
                            <option value="" disabled>Bitte auswählen</option>

                            <?php foreach (Degree::all() as $value => $label) : ?>
                                <option value="<?php echo $value ?>"><?php echo $label ?></option>
                            <?php endforeach ?>
                        </select>

                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('degree')" 
                            x-html="form.errors.get('degree')"            
                        ></div>
                    </div>
                    <div class="x-box-border x-flex-50 x-pl-2 omt-form-group">
                        <label for="specialty">Fachbereich des höchsten Bildungsabschlusses <span class="x-text-red-600">*</span></label>

                        <select id="specialty" name="jobs_fachrichtung" x-model="form.specialty" x-init="watcher('specialty')" class="dropdown" required="required">
                            <option value="" disabled>Bitte auswählen</option>

                            <?php foreach (Specialty::all() as $value => $label) : ?>
                                <option value="<?php echo $value ?>"><?php echo $label ?></option>
                            <?php endforeach ?>
                        </select>

                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('specialty')" 
                            x-html="form.errors.get('specialty')"            
                        ></div>
                    </div>
                </div>

                <div class="x-pb-10">
                    <label for="linkedin_url">Link zum LinkedIn-Profil</label>
                    <div class="x-pb-2 x-text-xs">Falls nicht vorhanden, bitte den Link zum XING-Profil oder anderen Job-Profil Seiten einfügen</div>
                    <input type="text" id="linkedin_url" name="linkedin_url" x-model="form.linkedin_url" x-init="watcher('linkedin_url')">
                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('linkedin_url')" 
                        x-html="form.errors.get('linkedin_url')"            
                    ></div>
                </div>

                <h3 class="x-m-0 x-pb-2">Spar Dir die Zeit und lade Deinen Lebenslauf direkt hoch</h3>

                <div class="x-pb-10">    
                    <label for="resume">Hier kannst Du Deinen Lebenslauf hochladen (Upload als PDF wird empfohlen)</label>
                    <div class="x-pb-2 x-text-xs">Bitte mindestens einen Lebenslauf (PDF-Format) oder den Link zum LinkedIn-Profil hochladen. Idealerweise Beide.</div>
                    
                    <div class="x-border-3 x-border-red x-border-solid x-pb-2 x-pl-2 x-pr-2 x-pt-2">
                        <input 
                            type="file"
                            name="jobs_lebenslauf_upload"
                            id="resume"
                            @change="form.resume = $event.target.files[0]"
                        >
                    </div>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('resume')" 
                        x-html="form.errors.get('resume')"            
                    ></div>

                    <template x-if="file">
                        <div class="x-mt-2 x-text-red-600 x-text-sm">
                            Hochgeladener Lebenslauf: <a href="/account/resume/?open-file" target="_blank" x-text="file.name"></a>
                        </div>
                    </template>
                </div>

                <h3 class="x-m-0 x-pb-4">Du hast Deinen Lebenslauf nicht zur Hand? Hier kannst Du Deine Daten manuell eingeben</h3>

                <div class="x-pb-4">
                    <label for="position">Aktuelle Position/Jobbezeichnung</label>
                    <input type="text" id="position" placeholder="z.B. Senior SEO-Manager" name="jobs_aktuelle_position" x-model="form.position" x-init="watcher('position')">
                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('position')" 
                        x-html="form.errors.get('position')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group">
                    <label for="marketing_area">Aktueller Online Marketing Bereich</label>
                    
                    <select id="marketing_area" name="jobs_aktueller_online_marketing_bereich" x-model="form.marketing_area" x-init="watcher('marketing_area')" class="dropdown">
                        <option value="0" disabled>Bitte auswählen</option>

                        <?php foreach (Magazines::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('marketing_area')" 
                        x-html="form.errors.get('marketing_area')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group">
                    <label for="branch">Aktuelle Branche</label>
                    
                    <select id="branch" name="jobs_aktuelle_branche" x-model="form.branch" x-init="watcher('branch')" class="dropdown">
                        <option value="0" disabled>Bitte auswählen</option>

                        <?php foreach (Branch::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('branch')"
                        x-html="form.errors.get('branch')"
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group">
                    <label for="experience">Wieviel Jahre Berufserfahrung hast Du insgesamt im Online Marketing?</label>
                    
                    <select id="experience" name="jobs_berufserfahrung_online_marketing_allgemein" x-model="form.experience" x-init="watcher('experience')" class="dropdown">
                        <option value="0" disabled>Bitte auswählen</option>

                        <?php foreach (Experience::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience')"
                        x-html="form.errors.get('experience')"
                    ></div>
                </div>

                <!-- Experience details -->
                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_am">Berufserfahrung im Affiliate Marketing</label>
                    
                    <select id="experience_am" name="jobs_berufserfahrung_affiliate_marketing" x-model="form.experience_am" x-init="watcher('experience_am')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_am')" 
                        x-html="form.errors.get('experience_am')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_cm">Berufserfahrung im Content Marketing</label>
                    
                    <select id="experience_cm" name="jobs_berufserfahrung_content_marketing" x-model="form.experience_cm" x-init="watcher('experience_cm')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_cm')" 
                        x-html="form.errors.get('experience_cm')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_em">Berufserfahrung im E-Mail-Marketing</label>
                    
                    <select id="experience_em" name="jobs_berufserfahrung_e_mail_marketing" x-model="form.experience_em" x-init="watcher('experience_em')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_em')" 
                        x-html="form.errors.get('experience_em')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_ga">Berufserfahrung im Google Ads</label>
                    
                    <select id="experience_ga" name="jobs_berufserfahrung_google_ads" x-model="form.experience_ga" x-init="watcher('experience_ga')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_ga')" 
                        x-html="form.errors.get('experience_ga')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_im">Berufserfahrung im Inbound Marketing</label>
                    
                    <select id="experience_im" name="jobs_berufserfahrung_inbound_marketing" x-model="form.experience_im" x-init="watcher('experience_im')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_im')" 
                        x-html="form.errors.get('experience_im')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_pr">Berufserfahrung im Public Relations (PR)</label>
                    
                    <select id="experience_pr" name="jobs_berufserfahrung_public_relations__pr_" x-model="form.experience_pr" x-init="watcher('experience_pr')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_pr')" 
                        x-html="form.errors.get('experience_pr')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_seo">Berufserfahrung im SEO</label>
                    
                    <select id="experience_seo" name="jobs_berufserfahrung_seo" x-model="form.experience_seo" x-init="watcher('experience_seo')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_seo')" 
                        x-html="form.errors.get('experience_seo')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_smm">Berufserfahrung im Social Media Marketing</label>
                    
                    <select id="experience_smm" name="jobs_berufserfahrung_social_media_marketing" x-model="form.experience_smm" x-init="watcher('experience_smm')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_smm')" 
                        x-html="form.errors.get('experience_smm')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_vm">Berufserfahrung im Video Marketing</label>
                    
                    <select id="experience_vm" name="jobs_berufserfahrung_video_marketing" x-model="form.experience_vm" x-init="watcher('experience_vm')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_vm')" 
                        x-html="form.errors.get('experience_vm')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="experience_wd">Berufserfahrung im Webdesign</label>
                    
                    <select id="experience_wd" name="jobs_berufserfahrung_webdesign" x-model="form.experience_wd" x-init="watcher('experience_wd')" class="dropdown">
                        <?php foreach (ExperienceDetailed::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_wd')" 
                        x-html="form.errors.get('experience_wd')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label for="leadership_experience">Welche Führungserfahrung hast Du?</label>
                    
                    <select id="leadership_experience" name="jobs_fuhrungserfahrung" x-model="form.leadership_experience" x-init="watcher('leadership_experience')" class="dropdown">
                        <?php foreach (LeadershipExperience::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('leadership_experience')" 
                        x-html="form.errors.get('leadership_experience')"            
                    ></div>
                </div>

                <div class="x-pb-4 omt-form-group" x-show="form.experience >= <?php echo Experience::ONE_TWO_YEARS ?>">
                    <label>In welchen Branchen warst Du bzw. bist Du tätig?</label>

                    <?php foreach (Branch::all() as $value => $label) : ?>
                        <div>
                            <input type="text" class="job-profile-hidden-field" name="<?php echo Branch::hubspotField($value) ?>" x-ref="<?php echo 'experience_industries_' . $value ?>">

                            <label class="checkbox-label">
                                <input 
                                    type="checkbox" 
                                    value="<?php echo $value ?>" 
                                    x-model.number="form.experience_industries" 
                                    x-init="watcher('experience_industries')" 
                                />

                                <?php echo $label ?>
                            </label>
                        </div>
                    <?php endforeach ?>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('experience_industries')" 
                        x-html="form.errors.get('experience_industries')"            
                    ></div>
                </div>
                <!-- End Experience details -->

                <div class="x-pb-4 omt-form-group">
                    <label for="tools_knowledge">Welche Tool-Kenntnisse hast Du und wie würdest Du sie bewerten?</label>
                    <div class="x-pb-2 x-text-xs">Bitte gib das Kenntnisniveau in folgenden Stufen an: "Grundkenntnisse", "fortgeschrittene Kenntnisse" oder "Expertenkenntnisse"</div>
                    <textarea type="text" id="tools_knowledge" placeholder="Beispiel: Google Analytics (Grundkenntnisse)" name="jobs_tool_kenntnisse" x-model="form.tools_knowledge" x-init="watcher('tools_knowledge')"></textarea>
                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('tools_knowledge')" 
                        x-html="form.errors.get('tools_knowledge')"            
                    ></div>
                </div>

                <div class="x-flex x-pb-4">
                    <div class="x-box-border x-flex-50 x-pr-2 omt-form-group">
                        <label for="german_level">Sprachkenntnisse - Deutsch</label>

                        <select id="german_level" name="jobs_sprachenkenntnisse_deutsch" x-model="form.german_level" x-init="watcher('german_level')" class="dropdown">
                            <option value="0" disabled>Bitte auswählen</option>

                            <?php foreach (LanguageLevel::all() as $value => $label) : ?>
                                <option value="<?php echo $value ?>"><?php echo $label ?></option>
                            <?php endforeach ?>
                        </select>

                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('german_level')" 
                            x-html="form.errors.get('german_level')"            
                        ></div>
                    </div>
                    <div class="x-box-border x-flex-50 x-pl-2 omt-form-group">
                        <label for="english_level">Sprachkenntnisse - Englisch</label>

                        <select id="english_level" name="jobs_sprachenkenntnisse_englisch" x-model="form.english_level" x-init="watcher('english_level')" class="dropdown">
                            <option value="0" disabled>Bitte auswählen</option>

                            <?php foreach (LanguageLevel::all() as $value => $label) : ?>
                                <option value="<?php echo $value ?>"><?php echo $label ?></option>
                            <?php endforeach ?>
                        </select>

                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('english_level')" 
                            x-html="form.errors.get('english_level')"            
                        ></div>
                    </div>
                </div>

                <div class="x-flex x-pb-4">
                    <div class="x-box-border x-flex-50 x-pr-2 omt-form-group">
                        <label for="french_level">Sprachkenntnisse - Französisch</label>

                        <select id="french_level" name="jobs_sprachenkenntnisse_franzosisch" x-model="form.french_level" x-init="watcher('french_level')" class="dropdown">
                            <option value="0" disabled>Bitte auswählen</option>

                            <?php foreach (LanguageLevel::all() as $value => $label) : ?>
                                <option value="<?php echo $value ?>"><?php echo $label ?></option>
                            <?php endforeach ?>
                        </select>

                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('french_level')" 
                            x-html="form.errors.get('french_level')"            
                        ></div>
                    </div>
                    <div class="x-box-border x-flex-50 x-pl-2 omt-form-group">
                        <label for="spanish_level">Sprachkenntnisse - Spanisch</label>

                        <select id="spanish_level" name="jobs_sprachenkenntnisse_spanisch" x-model="form.spanish_level" x-init="watcher('spanish_level')" class="dropdown">
                            <option value="0" disabled>Bitte auswählen</option>

                            <?php foreach (LanguageLevel::all() as $value => $label) : ?>
                                <option value="<?php echo $value ?>"><?php echo $label ?></option>
                            <?php endforeach ?>
                        </select>

                        <div
                            role="alert" 
                            class="x-pt-2 x-text-red-600 x-text-xs"
                            x-show="form.errors.has('spanish_level')" 
                            x-html="form.errors.get('spanish_level')"            
                        ></div>
                    </div>
                </div>

                <div class="x-pb-4 omt-form-group">
                    <label for="job_status">Wie würdest Du Deinen aktuellen Job-Status beschreiben?</label>
                    
                    <select id="job_status" name="jobs_suchstatus" x-model="form.job_status" x-init="watcher('job_status')" class="dropdown">
                        <option value="0" disabled>Bitte auswählen</option>

                        <?php foreach (JobStatus::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('job_status')" 
                        x-html="form.errors.get('job_status')"            
                    ></div>
                </div>

                <!-- Job status options -->
                <div class="x-pb-4" x-show="form.job_status == <?php echo JobStatus::LOOKING_OCCASIONALLY ?> || form.job_status == <?php echo JobStatus::LOOKING_ACTIVE ?>">
                    <label>Aus welchen Gründen denkst Du über einen neuen Job nach?</label>

                    <?php foreach (JobChangeReason::all() as $value => $label) : ?>
                        <div>
                            <input type="text" class="job-profile-hidden-field" name="<?php echo JobChangeReason::hubspotField($value) ?>" x-ref="<?php echo 'job_change_reason_' . $value ?>">
                            
                            <label class="checkbox-label">
                                <input 
                                    type="checkbox" 
                                    value="<?php echo $value ?>" 
                                    x-model.number="form.job_change_reason" 
                                    x-init="watcher('job_change_reason')"
                                />

                                <?php echo $label ?>
                            </label>
                        </div>
                    <?php endforeach ?>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('job_change_reason')" 
                        x-html="form.errors.get('job_change_reason')"            
                    ></div>
                </div>

                <div class="x-pb-4" x-show="form.job_status == <?php echo JobStatus::LOOKING_OCCASIONALLY ?> || form.job_status == <?php echo JobStatus::LOOKING_ACTIVE ?>">
                    <label>In welchen Online Marketing Bereichen sind Stellen für Dich von Interesse?</label>

                    <?php foreach (Magazines::all() as $value => $label) : ?>
                        <div>
                            <input type="text" class="job-profile-hidden-field" name="<?php echo Magazines::hubspotField($value) ?>" x-ref="<?php echo 'marketing_area_interest_' . $value ?>">
                            
                            <label class="checkbox-label">
                                <input
                                    type="checkbox" 
                                    value="<?php echo $value ?>" 
                                    x-model="form.marketing_area_interest" 
                                    x-init="watcher('marketing_area_interest')"
                                >

                                <?php echo $label ?>
                            </label>
                        </div>
                    <?php endforeach ?>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('marketing_area_interest')" 
                        x-html="form.errors.get('marketing_area_interest')"            
                    ></div>
                </div>
                <!-- End Job status options -->

                <div class="x-pb-4 omt-form-group">
                    <label for="annual_salary">Aktuelles Jahresgehalt (Brutto)</label>
                    
                    <select id="annual_salary" name="jobs_aktuelles_jahresgehalt_brutto" x-model="form.annual_salary" x-init="watcher('annual_salary')" class="dropdown">
                        <option value="0" disabled>Bitte auswählen</option>

                        <?php foreach (AnnualSalary::all() as $value => $label) : ?>
                            <option value="<?php echo $value ?>"><?php echo $label ?></option>
                        <?php endforeach ?>
                    </select>

                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('annual_salary')" 
                        x-html="form.errors.get('annual_salary')"            
                    ></div>
                </div>

                <div class="x-pb-4">
                    <label for="comment">Möchtest Du sonstige Anmerkungen zu Deinem Profil oder Deinen Interessen ergänzen?</label>
                    <div class="x-pb-2 x-text-xs">Erkläre uns mehr zu Deinen Wissenstand bzw. Deiner Situation und Motivation, damit wir einschätzen können, wie wir Dich am besten unterstützen können.  - Was ist Dein Ziel? - Wie würdest Du Deine Vorkenntnisse beschreiben? - Erzähl uns mehr zu Deiner Person. - Was ist Dein Expertengebiet (Alle Infos sind natürlich freiwillig)</div>
                    <textarea type="text" id="comment" name="jobs_sonstige_anmerkungen" x-model="form.comment"></textarea x-init="watcher('comment')">
                    <div
                        role="alert" 
                        class="x-pt-2 x-text-red-600 x-text-xs"
                        x-show="form.errors.has('comment')" 
                        x-html="form.errors.get('comment')"            
                    ></div>
                </div>

                <div class="um-left x-pt-4">
                    <button 
                        type="submit"
                        class="um-button"
                        :disabled="form.loading"
                    >
                        <svg x-show="form.loading" class="x-animate-spin x-h-4 x-w-4 x-align-middle x-mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="x-opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="x-opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>

                        Jetzt kostenfrei Job-Profil anlegen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>