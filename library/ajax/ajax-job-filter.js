$('.jobs_filter').change(function() {
        $('#jobs').hide();
        $("#filter_loader").show();
        var category =  document.getElementsByName('category');
        var erfahrung =  document.getElementsByName('erfahrung');
        var arbeiten =  document.getElementsByName('stadt');
        var occupation =  document.getElementsByName('occupation');
        var resultCategory = [];
        var resultErfahrung = [];
        var queryString = $('#jobs_filter_form').serialize();

        var resultArbeiten = [];
        var resultOccupation = [];

        var result = [];
        for (var i = 0; i < category.length; i++) {
            if (category[i].checked) {
                resultCategory.push(category[i].value);
            }
        }
        for (var i = 0; i < erfahrung.length; i++) {
            if (erfahrung[i].checked) {
                resultErfahrung.push(erfahrung[i].value);
            }
        }

        for (var i = 0; i < arbeiten.length; i++) {
            if (arbeiten[i].checked) {
                resultArbeiten.push(arbeiten[i].value);
            }
        }

        for (var i = 0; i < occupation.length; i++) {
            if (occupation[i].checked) {
                resultOccupation.push(occupation[i].value);
            }
        }
        result = [ resultCategory, resultErfahrung];

        $('.category_c').each(function(){
          var $this = $(this),
              categoty_id = $this.attr('id'); // Capture the ID
              //console.log(categoty_id);
        });


        $.ajax({
            url: jobfilter.ajax_url,
            data: {
                action: 'do_filter_jobs',
                categories: resultCategory,
                erfahrung: resultErfahrung,
                arbeitens: resultArbeiten,
                occupations: resultOccupation,
                nonce: jobfilter.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    //console.log(data);
                    $("#filter_loader").hide();
                    $('#jobs').html(data.content).show();


                        if (resultArbeiten.length > 0 && resultOccupation.length == 0 && resultCategory == 0 && resultErfahrung.length == 0 ){
                            // occupation count 

                            if(data.occupation.length > 0){
                                $('.besch_c').html('(0)').show();//empty filter data
                                data.occupation.sort();
                                var currentOccup = null;
                                var cntOccup = 0;
                                for (var i = 0; i < data.occupation.length; i++) {
                                    if (data.occupation[i] != currentOccup) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.occupation[i]);
                                        var yes_x = x_x.classList.contains(data.occupation[i]);
                                        if (cntOccup > 0) {$('.'+currentOccup).html('('+ cntOccup + ')').show();}
                                        currentOccup = data.occupation[i];
                                        cntOccup = 1;
                                    } else {cntOccup++;}
                                }
                                if (cntOccup > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentOccup);
                                    var yes_x = x_x.classList.contains(currentOccup);
                                    $('.'+currentOccup).html('('+ cntOccup + ')').show();
                                }
                            }
                            

                            // Category count
                            if(data.categories.length > 0){
                                $('.category_c').html('(0)').show();//empty filter data
                                data.categories.sort();
                                var currentCat = null;
                                var cntCat = 0;
                                for (var i = 0; i < ; i++) {
                                    if (data.categories[i] != currentCat) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.categories[i]);
                                        var yes_x = x_x.classList.contains(data.categories[i]);
                                        if (cntCat > 0) { $('.'+currentCat).html('('+ cntCat + ')').show();}
                                        currentCat = data.categories[i];
                                        cntCat = 1;
                                    } else {cntCat++;}
                                }
                                if (cntCat > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentCat);
                                    var yes_x = x_x.classList.contains(currentCat);
                                    $('.'+currentCat).html('('+ cntCat + ')').show();
                                }
                            }
                            

                            //level count
                            if(data.erfahrung.length > 0){
                                $('.erfahrung_c').html('(0)').show();//empty filter data
                                data.erfahrung.sort();
                                var currentErf = null;
                                var cntErf = 0;
                                for (var i = 0; i < data.erfahrung.length; i++) {
                                    if (data.erfahrung[i] != currentErf) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.erfahrung[i]);
                                        var yes_x = x_x.classList.contains(data.erfahrung[i]);
                                        if (cntErf > 0) {$('.'+currentErf).html('('+ cntErf + ')').show();}
                                        currentErf = data.erfahrung[i];
                                        cntErf = 1;
                                    } else {cntErf++;}
                                }
                                if (cntErf > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentErf);
                                    var yes_x = x_x.classList.contains(currentErf);
                                    $('.'+currentErf).html('('+ cntErf + ')').show();
                                }
                            }
                            

                           
                        }else if(resultArbeiten.length == 0 && resultOccupation.length > 0 && resultCategory == 0 && resultErfahrung.length == 0){
                                //City count
                            $('.stadt_c').html('(0)').show();//empty filter data
                            data.arbeiten.sort();
                            var currentArbeiten = null;
                            var cntArbeiten = 0;
                            for (var i = 0; i < data.arbeiten.length; i++) {
                                if (data.arbeiten[i] != currentArbeiten) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.arbeiten[i]);
                                    var yes_x = x_x.classList.contains(data.arbeiten[i]);
                                    if (cntArbeiten > 0) {$('.'+currentArbeiten).html('('+ cntArbeiten + ')').show();}
                                    currentArbeiten = data.arbeiten[i];
                                    cntArbeiten = 1;
                                } else {cntArbeiten++;}
                            }
                            if (cntArbeiten > 0) {
                                var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentArbeiten);
                                var yes_x = x_x.classList.contains(currentArbeiten);
                                $('.'+currentArbeiten).html('('+ cntArbeiten + ')').show();
                            }

                            // Category count
                            if(data.categories.length > 0){
                                $('.category_c').html('(0)').show();//empty filter data
                                data.categories.sort();
                                var currentCat = null;
                                var cntCat = 0;
                                for (var i = 0; i < ; i++) {
                                    if (data.categories[i] != currentCat) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.categories[i]);
                                        var yes_x = x_x.classList.contains(data.categories[i]);
                                        if (cntCat > 0) { $('.'+currentCat).html('('+ cntCat + ')').show();}
                                        currentCat = data.categories[i];
                                        cntCat = 1;
                                    } else {cntCat++;}
                                }
                                if (cntCat > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentCat);
                                    var yes_x = x_x.classList.contains(currentCat);
                                    $('.'+currentCat).html('('+ cntCat + ')').show();
                                }
                            }

                            //level count
                            if(data.erfahrung.length > 0){
                                $('.erfahrung_c').html('(0)').show();//empty filter data
                                data.erfahrung.sort();
                                var currentErf = null;
                                var cntErf = 0;
                                for (var i = 0; i < data.erfahrung.length; i++) {
                                    if (data.erfahrung[i] != currentErf) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.erfahrung[i]);
                                        var yes_x = x_x.classList.contains(data.erfahrung[i]);
                                        if (cntErf > 0) {$('.'+currentErf).html('('+ cntErf + ')').show();}
                                        currentErf = data.erfahrung[i];
                                        cntErf = 1;
                                    } else {cntErf++;}
                                }
                                if (cntErf > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentErf);
                                    var yes_x = x_x.classList.contains(currentErf);
                                    $('.'+currentErf).html('('+ cntErf + ')').show();
                                }
                            }
                        }else if(resultArbeiten.length == 0 && resultOccupation.length == 0 && resultCategory  > 0 && resultErfahrung.length == 0){
                            //City count
                            $('.stadt_c').html('(0)').show();//empty filter data
                            data.arbeiten.sort();
                            var currentArbeiten = null;
                            var cntArbeiten = 0;
                            for (var i = 0; i < data.arbeiten.length; i++) {
                                if (data.arbeiten[i] != currentArbeiten) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.arbeiten[i]);
                                    var yes_x = x_x.classList.contains(data.arbeiten[i]);
                                    if (cntArbeiten > 0) {$('.'+currentArbeiten).html('('+ cntArbeiten + ')').show();}
                                    currentArbeiten = data.arbeiten[i];
                                    cntArbeiten = 1;
                                } else {cntArbeiten++;}
                            }
                            if (cntArbeiten > 0) {
                                var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentArbeiten);
                                var yes_x = x_x.classList.contains(currentArbeiten);
                                $('.'+currentArbeiten).html('('+ cntArbeiten + ')').show();
                            }

                            // occupation count 
                            if(data.occupation.length > 0){
                                $('.besch_c').html('(0)').show();//empty filter data
                                data.occupation.sort();
                                var currentOccup = null;
                                var cntOccup = 0;
                                for (var i = 0; i < data.occupation.length; i++) {
                                    if (data.occupation[i] != currentOccup) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.occupation[i]);
                                        var yes_x = x_x.classList.contains(data.occupation[i]);
                                        if (cntOccup > 0) {$('.'+currentOccup).html('('+ cntOccup + ')').show();}
                                        currentOccup = data.occupation[i];
                                        cntOccup = 1;
                                    } else {cntOccup++;}
                                }
                                if (cntOccup > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentOccup);
                                    var yes_x = x_x.classList.contains(currentOccup);
                                    $('.'+currentOccup).html('('+ cntOccup + ')').show();
                                }
                            }

                            //level count
                            if(data.erfahrung.length > 0){
                                $('.erfahrung_c').html('(0)').show();//empty filter data
                                data.erfahrung.sort();
                                var currentErf = null;
                                var cntErf = 0;
                                for (var i = 0; i < data.erfahrung.length; i++) {
                                    if (data.erfahrung[i] != currentErf) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.erfahrung[i]);
                                        var yes_x = x_x.classList.contains(data.erfahrung[i]);
                                        if (cntErf > 0) {$('.'+currentErf).html('('+ cntErf + ')').show();}
                                        currentErf = data.erfahrung[i];
                                        cntErf = 1;
                                    } else {cntErf++;}
                                }
                                if (cntErf > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentErf);
                                    var yes_x = x_x.classList.contains(currentErf);
                                    $('.'+currentErf).html('('+ cntErf + ')').show();
                                }
                            }
                        }else if(resultArbeiten.length == 0 && resultOccupation.length == 0 && resultCategory == 0 && resultErfahrung.length > 0){
                            
                            //City count
                            $('.stadt_c').html('(0)').show();//empty filter data
                            data.arbeiten.sort();
                            var currentArbeiten = null;
                            var cntArbeiten = 0;
                            for (var i = 0; i < data.arbeiten.length; i++) {
                                if (data.arbeiten[i] != currentArbeiten) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.arbeiten[i]);
                                    var yes_x = x_x.classList.contains(data.arbeiten[i]);
                                    if (cntArbeiten > 0) {$('.'+currentArbeiten).html('('+ cntArbeiten + ')').show();}
                                    currentArbeiten = data.arbeiten[i];
                                    cntArbeiten = 1;
                                } else {cntArbeiten++;}
                            }
                            if (cntArbeiten > 0) {
                                var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentArbeiten);
                                var yes_x = x_x.classList.contains(currentArbeiten);
                                $('.'+currentArbeiten).html('('+ cntArbeiten + ')').show();
                            }

                            // occupation count 
                            if(data.occupation.length > 0){
                                $('.besch_c').html('(0)').show();//empty filter data
                                data.occupation.sort();
                                var currentOccup = null;
                                var cntOccup = 0;
                                for (var i = 0; i < data.occupation.length; i++) {
                                    if (data.occupation[i] != currentOccup) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.occupation[i]);
                                        var yes_x = x_x.classList.contains(data.occupation[i]);
                                        if (cntOccup > 0) {$('.'+currentOccup).html('('+ cntOccup + ')').show();}
                                        currentOccup = data.occupation[i];
                                        cntOccup = 1;
                                    } else {cntOccup++;}
                                }
                                if (cntOccup > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentOccup);
                                    var yes_x = x_x.classList.contains(currentOccup);
                                    $('.'+currentOccup).html('('+ cntOccup + ')').show();
                                }
                            }

                            // Category count
                            if(data.categories.length > 0){
                                $('.category_c').html('(0)').show();//empty filter data
                                data.categories.sort();
                                var currentCat = null;
                                var cntCat = 0;
                                for (var i = 0; i < ; i++) {
                                    if (data.categories[i] != currentCat) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.categories[i]);
                                        var yes_x = x_x.classList.contains(data.categories[i]);
                                        if (cntCat > 0) { $('.'+currentCat).html('('+ cntCat + ')').show();}
                                        currentCat = data.categories[i];
                                        cntCat = 1;
                                    } else {cntCat++;}
                                }
                                if (cntCat > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentCat);
                                    var yes_x = x_x.classList.contains(currentCat);
                                    $('.'+currentCat).html('('+ cntCat + ')').show();
                                }
                            }
                          
                        }else{
                            //City count
                            $('.stadt_c').html('(0)').show();//empty filter data
                            data.arbeiten.sort();
                            var currentArbeiten = null;
                            var cntArbeiten = 0;
                            for (var i = 0; i < data.arbeiten.length; i++) {
                                console.log(data.arbeiten[i]);
                                if (data.arbeiten[i] != currentArbeiten) {
                                    if(data.arbeiten[i] != ''){
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.arbeiten[i]);
                                        var yes_x = x_x.classList.contains(data.arbeiten[i]);
                                        if (cntArbeiten > 0) {$('.'+currentArbeiten).html('('+ cntArbeiten + ')').show();}
                                        currentArbeiten = data.arbeiten[i];
                                        cntArbeiten = 1;
                                    }
                                } else {cntArbeiten++;}
                            }
                            if (cntArbeiten > 0) {
                                var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentArbeiten);
                                var yes_x = x_x.classList.contains(currentArbeiten);
                                $('.'+currentArbeiten).html('('+ cntArbeiten + ')').show();
                            }

                            // occupation count 
                            if(data.occupation.length > 0){
                                $('.besch_c').html('(0)').show();//empty filter data
                                data.occupation.sort();
                                var currentOccup = null;
                                var cntOccup = 0;
                                for (var i = 0; i < data.occupation.length; i++) {
                                    if (data.occupation[i] != currentOccup) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.occupation[i]);
                                        var yes_x = x_x.classList.contains(data.occupation[i]);
                                        if (cntOccup > 0) {$('.'+currentOccup).html('('+ cntOccup + ')').show();}
                                        currentOccup = data.occupation[i];
                                        cntOccup = 1;
                                    } else {cntOccup++;}
                                }
                                if (cntOccup > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentOccup);
                                    var yes_x = x_x.classList.contains(currentOccup);
                                    $('.'+currentOccup).html('('+ cntOccup + ')').show();
                                }
                            }

                            // Category count
                            if(data.categories.length > 0){
                                $('.category_c').html('(0)').show();//empty filter data
                                data.categories.sort();
                                var currentCat = null;
                                var cntCat = 0;
                                for (var i = 0; i < ; i++) {
                                    if (data.categories[i] != currentCat) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.categories[i]);
                                        var yes_x = x_x.classList.contains(data.categories[i]);
                                        if (cntCat > 0) { $('.'+currentCat).html('('+ cntCat + ')').show();}
                                        currentCat = data.categories[i];
                                        cntCat = 1;
                                    } else {cntCat++;}
                                }
                                if (cntCat > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentCat);
                                    var yes_x = x_x.classList.contains(currentCat);
                                    $('.'+currentCat).html('('+ cntCat + ')').show();
                                }
                            }

                            //level count
                            if(data.erfahrung.length > 0){
                                $('.erfahrung_c').html('(0)').show();//empty filter data
                                data.erfahrung.sort();
                                var currentErf = null;
                                var cntErf = 0;
                                for (var i = 0; i < data.erfahrung.length; i++) {
                                    if (data.erfahrung[i] != currentErf) {
                                        var x_x = document.getElementById("jobs_filter_form").querySelector("."+data.erfahrung[i]);
                                        var yes_x = x_x.classList.contains(data.erfahrung[i]);
                                        if (cntErf > 0) {$('.'+currentErf).html('('+ cntErf + ')').show();}
                                        currentErf = data.erfahrung[i];
                                        cntErf = 1;
                                    } else {cntErf++;}
                                }
                                if (cntErf > 0) {
                                    var x_x = document.getElementById("jobs_filter_form").querySelector("."+currentErf);
                                    var yes_x = x_x.classList.contains(currentErf);
                                    $('.'+currentErf).html('('+ cntErf + ')').show();
                                }
                            }     
                        }

                        


                        

                         

                    
                } else if (data.status === 201) {

                }
            },
            complete: function (data, textStatus) {
                msg = textStatus;
                if (textStatus === 'success') {
                    msg = data.responseJSON.found;
                }
            }
        });
});


