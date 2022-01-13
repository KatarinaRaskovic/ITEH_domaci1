console.log("Evo radim!");

$(document).ready(function() {
    $('select').material_select();

    $("#addSubject").click(function(){
        console.log("Adding new task...");
        $("#addModal").openModal("toggle");
        return false;
    });
    
    $("#exitAddModal").click(function(){
        $("#addModal").closeModal("toggle");
    });
    
    $("#closeAddModal").click(function(){
        $("#addModal").closeModal("toggle");
    });


    $("#exitEditModal").click(function(){
        $("#editModal").closeModal("toggle");
    });
    
    $("#closeEditModal").click(function(){
        $("#editModal").closeModal("toggle");
    });

    
    $("#addSubjectForm").submit(function(){
        event.preventDefault();
        console.log("Actually adding subject...");
        const $form = $(this);
        const $inputs = $form.find('input, button');
        var serializedData = $form.serialize();
        $inputs.prop('disabled', true);
        console.log(serializedData);

        request = $.ajax({
            url: 'api/subjects/insert.php',
            type: 'post',
            data: serializedData
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === 'Insertion successful...') {
                location.reload(true);
            } else {
                console.log('Subject NOT added: ' + response);
            }
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + textStatus, errorThrown);
        });      
    });
    
    $("[class*=btn-delete]").click(function(){
        console.log("Deleting subject...");
        var id = $(this).closest('li').attr('id');
        
        request = $.ajax({
            url: 'api/subjects/delete.php',
            type: 'post',
            data: {'id': id}
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === 'Deletion successful...') {
                location.reload(true);
            } else {
                console.log('Subject NOT deleted: ' + response);
                location.reload(true);
            }
            alert(id);
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + textStatus, errorThrown);
        });
        
    });

    $("[class*=btn-edit]").click(function(){
        console.log("Editing a task...");
        $("#editModal").openModal("toggle");

        var id = $(this).closest('li').attr('id');
        
        request = $.ajax({
            url: 'api/subjects/get.php',
            type: 'post',
            data: {'id': id},
            dataType : 'json'
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log(response);
            $('form#editSubjectForm').attr('class', response[0]['id']);
            $('#name').val(response[0]['name'].trim());
            $('#espb').val(response[0]['ESPB']);
            $('#semester').val(response[0]['semester']);
        });
    
        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + textStatus, errorThrown);
        });

        return false;
    });

    $('#editSubjectForm').submit(function(){
        event.preventDefault();
        console.log("Actually editing subject...");
        const $form = $(this);
        const $inputs = $form.find('input, button');

        var id = $(this).attr('class');
        var serializedData = $form.serialize();
        serializedData += "&id=" + encodeURIComponent(id);
        console.log(serializedData);
        $inputs.prop('disabled', true);

        request = $.ajax({
            url: 'api/subjects/update.php',
            type: 'post',
            data: serializedData
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === 'Update successful...') {
                location.reload(true);
            } else {
                console.log('Subject NOT updated: ' + response);
                location.reload(true);
            }
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + textStatus, errorThrown);
        });
    });

    // making contains case insensitive (used in search)
    $.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });

    $('.search').keypress(function (e) {
        var key = e.which;
        var query = $('.search').val();
        $(".subjectCard").css("display", "inline");

        if(key == 13) {
            $(".subjectCard:not(:contains('"+ query +"'))").css("display", "none");
            
            return false;  
         }
    });

    var espbSortClicks=0;
    $(".btnSortEspb").click(function(){
        console.log('Sorting by espb...');
        espbSortClicks++;
        
        if(espbSortClicks == 1){
            $(".subjectCard").sort(function(a, b) {
                da = parseInt($(a).find('.espbToSort').text().slice(6));
                db = parseInt($(b).find('.espbToSort').text().slice(6));
                return (da < db ? -1 : (da > db) ? 1 : 0);                          
            }).appendTo(".allSubjects");
        } else if(espbSortClicks == 2){
            $(".subjectCard").sort(function(a, b) {
                da = parseInt($(a).find('.espbToSort').text().slice(6));
                db = parseInt($(b).find('.espbToSort').text().slice(6));
                return (da > db ? -1 : (da < db) ? 1 : 0);                          
            }).appendTo(".allSubjects");
        } else {
            location.reload(true);
        }
        
    });

    var semesterSortClicks=0;
    $(".btnSortSemester").click(function(){
        console.log('Sorting by semester...');
        semesterSortClicks++;

        if(semesterSortClicks == 1){
            $(".subjectCard").sort(function(a, b) {
                da = parseInt($(a).find('.semesterToSort').text().slice(10));
                db = parseInt($(b).find('.semesterToSort').text().slice(10));
                return (da < db ? -1 : (da > db) ? 1 : 0);   
            }).appendTo(".allSubjects");
        } else if(semesterSortClicks == 2){
            $(".subjectCard").sort(function(a, b) {
                da = parseInt($(a).find('.semesterToSort').text().slice(10));
                db = parseInt($(b).find('.semesterToSort').text().slice(10));
                return (da > db ? -1 : (da < db) ? 1 : 0);   
            }).appendTo(".allSubjects");
        } else {
            location.reload(true);
        }
        
    });

  });
