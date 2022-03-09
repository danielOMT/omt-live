//BUTTON
(function() {
    tinymce.PluginManager.add('shortcode_button', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_button', {
            text: shortcode_button.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_button.button_title,
                    body: [
                        {
                            type   : 'listbox',
                            name   : 'farbe',
                            label  : 'Farbe',
                            values : [
                                { text: 'Blau', value: 'blue' },
                                { text: 'Rot', value: 'red' },
                                { text: 'Grau', value: 'grey' },
                                { text: 'Gradient', value: 'gradient' }
                            ],
                            value : 'blue' // Sets the default
                        },
                        {
                            type   : 'listbox',
                            name   : 'target',
                            label  : 'Fenster',
                            values : [
                                { text: 'gleiches Fenster', value: '_self' },
                                { text: 'neues Fenster', value: '_blank' }
                            ],
                            value : '_self' // Sets the default
                        },
                        {
                            type   : 'textbox',
                            name   : 'linktarget',
                            label  : 'Linkziel',
                            tooltip: 'Linkziel des Buttons',
                            value  : '#'
                        },
                        {
                            type   : 'textbox',
                            name   : 'text',
                            label  : 'Beschriftung',
                            tooltip: 'Beschriftung des Buttons',
                            value  : 'Jetzt Klicken!'
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[button farbe="' + e.data.farbe + '" link-target="' + e.data.linktarget + '" target="' + e.data.target + '"] ' + e.data.text + '[/button]');
                    }
                });
            },
        });
    });
})();
//end of shortcode BUTTON

//Webinar Widget
(function() {
    tinymce.PluginManager.add('shortcode_webinar', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_webinar', {
            text: shortcode_webinar.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_webinar.button_title,
                    body: [
                        {
                            type   : 'textbox',
                            name   : 'webinar_id',
                            label  : 'Webinar ID',
                            tooltip: 'ID des einzufügenden Webinars',
                            value  : '16018'
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[webinar_widget webinar="' + e.data.webinar_id + '"]');
                    }
                });
            },
        });
    });
})();
//END of Shortcode WEBINAR WIDGET

//Ebook Widget
(function() {
    tinymce.PluginManager.add('shortcode_ebook', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_ebook', {
            text: shortcode_ebook.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_ebook.button_title,
                    body: [
                        {
                            type   : 'textbox',
                            name   : 'ebook_id',
                            label  : 'Ebook ID',
                            tooltip: 'ID des einzufügenden Ebooks',
                            value  : '16018'
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[ebook_widget ebook="' + e.data.ebook_id + '"]');
                    }
                });
            },
        });
    });
})();
//END of Shortcode Ebook WIDGET

//CTA WIDGET
(function() {
    tinymce.PluginManager.add('shortcode_ctawidget', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_ctawidget', {
            text: shortcode_ctawidget.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_ctawidget.button_title,
                    body: [
                        {
                            type: 'textbox',
                            name: 'img',
                            label: shortcode_ctawidget.image_title,
                            value: '',
                            classes: 'my_input_image',
                        },
                        {
                            type: 'button',
                            name: 'my_upload_button',
                            label: '',
                            text: shortcode_ctawidget.image_button_title,
                            classes: 'my_upload_button',
                        },
                        {
                            type   : 'textbox',
                            name   : 'headline',
                            label  : 'Headline',
                            tooltip: '',
                            value  : ''
                        },
                        {
                            type   : 'textbox',
                            name   : 'headline_red',
                            label  : 'Headline Red',
                            tooltip: '',
                            value  : ''
                        },
                        {
                            type   : 'textbox',
                            name   : 'content',
                            label  : 'Beschreibung',
                            tooltip: '',
                            value  : ''
                        },
                        {
                            type   : 'textbox',
                            name   : 'button',
                            label  : 'Button Text',
                            tooltip: '',
                            value  : ''
                        },
                        {
                            type   : 'textbox',
                            name   : 'link',
                            label  : 'Linkziel',
                            tooltip: '',
                            value  : ''
                        },
                        {
                            type   : 'listbox',
                            name   : 'target',
                            label  : 'Fenster',
                            values : [
                                { text: 'gleiches Fenster', value: '_self' },
                                { text: 'neues Fenster', value: '_blank' }
                            ],
                            value : '_self' // Sets the default
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[cta-widget bild="' + e.data.img + '" headline="' + e.data.headline + '" headline_red="' + e.data.headline_red + '" content="' + e.data.content + '" button="' + e.data.button + '" link="' + e.data.link + '" target="' + e.data.target + '"]');
                    }
                });
            },
        });
    });
})();
//END of Shortcode CTA WIDGET

////ZITAT Widget
(function() {
    tinymce.PluginManager.add('shortcode_zitat', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_zitat', {
            text: shortcode_zitat.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_zitat.button_title,
                    body: [
                        {
                            type   : 'textbox',
                            name   : 'text',
                            label  : 'Text',
                            tooltip: 'Inhalt des Zitats',
                            value  : 'Zitat'
                        },
                        {
                            type   : 'listbox',
                            name   : 'farbe',
                            label  : 'Farbe',
                            values : [
                                { text: 'Blau', value: 'blue' },
                                { text: 'Rot', value: 'red' }
                            ],
                            value : 'blue' // Sets the default
                        },
                        {
                            type   : 'textbox',
                            name   : 'author',
                            label  : 'Author',
                            tooltip: 'Author des Zitats',
                            value  : 'Zitat Author'
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[zitat text="' + e.data.text + '" farbe="' + e.data.farbe + '" author="' + e.data.author + '"]');
                    }
                });
            },
        });
    });
})();
//END of Shortcode ZITAT WIDGET

//TITLEBOX WIDGET
(function() {
    tinymce.PluginManager.add('shortcode_titlebox', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_titlebox', {
            text: shortcode_titlebox.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_titlebox.button_title,
                    body: [
                        {
                            type   : 'textbox',
                            name   : 'title',
                            label  : 'Titel - unverändert lassen für OMT Logo',
                            tooltip: 'Wenn unverändert, wird OMT Logo ausgegeben - ansonsten der eingegebene Text',
                            value  : '<img class=\'titlebox-label-image\' src=\'/uploads/omt-logo.svg\'/>'
                        },
                        {
                            type   : 'textbox',
                            name   : 'icon',
                            label  : 'Optionales Icon',
                            tooltip: 'Nur bei HTML-Titel möglich. Zum Beispiel "check" - volle Liste siehe https://fontawesome.com/cheatsheet?from=io',
                            value : '' // Sets the default
                        },

                        {
                            type   : 'textbox',
                            name   : 'border_size',
                            label  : 'Dicke des Randes in Pixeln',
                            tooltip: 'Standardwert ist 1Px',
                            value  : '1'
                        },
                        {
                            type   : 'textbox',
                            name   : 'border_color',
                            label  : 'Farbe des Randes (hex)',
                            tooltip: 'Standardwert: #004590',
                            value  : '#004590'
                        },
                        {
                            type   : 'textbox',
                            name   : 'background',
                            label  : 'Hintergrundfarbe (hex)',
                            tooltip: 'Standardwert: #ffffff',
                            value  : '#ffffff'
                        },
                        {
                            type   : 'textbox',
                            name   : 'color',
                            label  : 'Textfarbe (hex)',
                            tooltip: 'Standardwert: #333333',
                            value  : '#333333'
                        },
                        {
                            type   : 'textbox',
                            name   : 'content',
                            label  : 'Textinhalt',
                            tooltip: 'Kann auch im Anschluss im Editor eingefügt werden.',
                            value  : ''
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[omt_titlebox title="' + e.data.title + '" icon="' + e.data.icon + '" border-size="' + e.data.border_size + '" border-color="' + e.data.border_color + '" background="' + e.data.background + '" color="' + e.data.color + '"]' + e.data.content + '[/omt_titlebox]');
                    }
                });
            },
        });
    });
})();
//END of Shortcode TITLEBOX WIDGET


////YOUTUBE Widget
(function() {
    tinymce.PluginManager.add('shortcode_youtube', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_youtube', {
            text: shortcode_youtube.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_youtube.button_title,
                    body: [
                        {
                            type   : 'textbox',
                            name   : 'id',
                            label  : 'Youtube Embed ID',
                            tooltip: 'Code hinter dem "v=" im Youtube-Video, zum Beispiel 58nDHhOp2cA für das Video https://www.youtube.com/watch?v=58nDHhOp2cA',
                            value  : '58nDHhOp2cA'
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[youtube id="' + e.data.id + '"]');
                    }
                });
            },
        });
    });
})();
//END of Shortcode YOUTUBE WIDGET

//Podcast Widget
(function() {
    tinymce.PluginManager.add('shortcode_podcast', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_podcast', {
            text: shortcode_podcast.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_podcast.button_title,
                    body: [
                        {
                            type   : 'textbox',
                            name   : 'podcast_id',
                            label  : 'Podcast ID',
                            tooltip: 'ID des einzufügenden Podcasts. Beispiel: 36256',
                            value  : ''
                        },
                        {
                            type   : 'textbox',
                            name   : 'soundcloud_track_id',
                            label  : 'Soundcloud Track ID',
                            tooltip: 'direkte Soundcloud Track ID des einzufügenden Podcasts. Falls secret_token enthalten, diesen mitkopieren. Beispiel: 773709289%3Fsecret_token%3Ds-oEhm6',
                            value  : ''
                        }
                        ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[soundcloud podcast="' + e.data.podcast_id + '" trackid="'+ e.data.soundcloud_track_id + '"]');
                    }
                });
            },
        });
    });
})();
//END of Shortcode Podcast WIDGET

//TikTok Widget
(function() {
    tinymce.PluginManager.add('shortcode_tiktok', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_tiktok', {
            text: shortcode_tiktok.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_tiktok.button_title,
                    body: [
                        {
                            type   : 'textbox',
                            name   : 'tiktok_url',
                            label  : 'TikTok URL',
                            tooltip: 'URL des TikTok Videos',
                            value  : 'https://www.tiktok.com/@omt.de/video/6819239034808831238'
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[tiktok url="' + e.data.tiktok_url+ '"]');
                    }
                });
            },
        });
    });
})();
//END of Shortcode TikTok WIDGET

//Spotify Widget
(function() {
    tinymce.PluginManager.add('shortcode_spotify', function( editor, url ) { //ADD SHORTCODE BUTTONS
        editor.addButton( 'shortcode_spotify', {
            text: shortcode_spotify.button_name,
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: shortcode_spotify.button_title,
                    body: [
                        {
                            type   : 'textbox',
                            name   : 'spotify_id',
                            label  : 'Spotify Embed ID',
                            tooltip: 'Embed ID des Videos, zu finden hinter dem https://open.spotify.com/embed-podcast/episode/',
                            value  : '6PRFO5PD4XWmCXbWQvSkjD'
                        },
                        {
                            type   : 'textbox',
                            name   : 'ctatitel',
                            label  : 'CTA Titel',
                            tooltip: 'Titel im CTA',
                            value  : 'Diesen Artikel jetzt als Podcast anhören'
                        }
                    ],
                    onsubmit: function( e ) {
                        editor.insertContent( '[spotify ctatitel="' + e.data.ctatitel+ '" trackid="' + e.data.spotify_id+ '"]');
                    }
                });
            },
        });
    });
})();
//END of Shortcode Spotify WIDGET


/////////////THIS WILL BE THE END (OF BUTTON DEFINITIONS)
//image uploader script
jQuery(document).ready(function($){
    $(document).on('click', '.mce-my_upload_button', upload_image_tinymce);

    function upload_image_tinymce(e) {
        e.preventDefault();
        var $input_field = $('.mce-my_input_image');
        var custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Add Image',
            button: {
                text: 'Add Image'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $input_field.val(attachment.url);
        });
        custom_uploader.open();
    }
});