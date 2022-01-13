console.log("Evo radim!");

$(document).ready(function() {
    $('select').material_select();

    $("#addTask").click(function(){
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

    
    $("#addTaskForm").submit(function(){
        event.preventDefault();
        console.log("Actually adding task...");
        const $form = $(this);
        const $inputs = $form.find('input, select, button, textarea');
        var isDone = $('.doneSwitch').prop('checked') === true ? 1 : 0;
        var serializedData = $form.serialize();
        serializedData += "&isDone=" + encodeURIComponent(isDone);
        console.log(serializedData);
        $inputs.prop('disabled', true);

        request = $.ajax({
            url: 'api/obligations/insert.php',
            type: 'post',
            data: serializedData
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === 'Insertion successful...') {
                location.reload(true);
            } else {
                console.log('Task NOT added: ' + response);
                location.reload(true);
            }
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + textStatus, errorThrown);
        });        
    });
    
    $("[class*=btn-delete]").click(function(){
        console.log("Deleting task...");
        var id = $(this).closest('li').attr('id');
        
        request = $.ajax({
            url: 'api/obligations/delete.php',
            type: 'post',
            data: {'id': id}
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === 'Deletion successful...') {
                location.reload(true);
            } else {
                console.log('Task NOT deleted: ' + response);
                location.reload(true);
            }
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
            url: 'api/obligations/get.php',
            type: 'post',
            data: {'id': id},
            dataType : 'json'
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log(response);
            $('form#editTaskForm').attr('class', response[0]['id']);
            $('#name').val(response[0]['task_name']);
            $('#description').val(response[0]['description'].trim());
            $('#date').val(response[0]['date'].trim());
            $('.doneSwitch').prop('checked', response[0]['isDone'] === "1" ? true : false);
            $('select option[value=' + response[0]['subject_id'].trim() + ']').prop('selected', true);
        });
    
        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + textStatus, errorThrown);
        });

        return false;
    });

    var toggle = 0;
    $('.doneSwitch').click(function(){
        toggle=0;
        $(this).prop('checked') === true ? $(this).prop('checked', true) : $(this).prop('checked', false);
        toggle++;
    });

    $('#editTaskForm').submit(function(){
        event.preventDefault();
        console.log("Actually editing task...");

        const $form = $(this);
        const $inputs = $form.find('input, select, button, textarea');

        var id = $(this).attr('class');
        
        var isDone = (toggle > 0 ? !$('.doneSwitch').prop('checked') : $('.doneSwitch').prop('checked')) ? 1 : 0;
        var serializedData = $form.serialize();
        serializedData += "&isDone=" + encodeURIComponent(isDone);
        serializedData += "&id=" + encodeURIComponent(id);
        console.log(serializedData);
        $inputs.prop('disabled', true);

        request = $.ajax({
            url: 'api/obligations/update.php',
            type: 'post',
            data: serializedData
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === 'Update successful...') {
                location.reload(true);
            } else {
                console.log('Task NOT added: ' + response);
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
        $(".taskCard").css("display", "inline");

        if(key == 13) {
            $(".taskCard:not(:contains('"+ query +"'))").css("display", "none");
            
            return false;  
         }
    });

    var dateSortClicks = 0;
    $(".btnSortDate").click(function(){
        console.log('Sorting by date...');
        dateSortClicks++;

        if(dateSortClicks == 1){
            $(".taskCard").sort(function(a, b) {
                da = new Date( $(a).find('.dateToSort').text().slice(5) ); 
                console.log(da);
                db = new Date( $(b).find('.dateToSort').text().slice(5) );
                return (da < db ? -1 : (da > db) ? 1 : 0);                          
            }).appendTo(".allTasks");
        } else if(dateSortClicks == 2){
            $(".taskCard").sort(function(a, b) {
                da = new Date( $(a).find('.dateToSort').text().slice(5) ); 
                console.log(da);
                db = new Date( $(b).find('.dateToSort').text().slice(5) );
                return (da > db ? -1 : (da < db) ? 1 : 0);                          
            }).appendTo(".allTasks");
        } else {
            location.reload(true);
        }
        
    });

    var finSortClicks = 0;
    $(".btnSortFinished").click(function(){
        console.log('Sorting by finished...');

        finSortClicks++;

        if(finSortClicks == 1){
            $(".taskCard").sort(function(a, b) {
                da = $(a).find(".finishedToSort").text().slice(9) === "Finished" ? 1 : 0; 
                console.log(da);
                db = $(b).find(".finishedToSort").text().slice(9) === "Finished" ? 1 : 0; 
                return (da < db ? -1 : (da > db) ? 1 : 0);                          
            }).appendTo(".allTasks");
        } else if(finSortClicks == 2){
            $(".taskCard").sort(function(a, b) {
                da = $(a).find(".finishedToSort").text().slice(9) === "Finished" ? 1 : 0; 
                console.log(da);
                db = $(b).find(".finishedToSort").text().slice(9) === "Finished" ? 1 : 0; 
                return (da > db ? -1 : (da < db) ? 1 : 0);                          
            }).appendTo(".allTasks");
        } else {
            location.reload(true);
        }
    });

  });
