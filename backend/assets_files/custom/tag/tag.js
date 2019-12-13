$(document).ready(function() {

    $('#createTag').click(function () {
        swal({
                title: "Добавить тег",
                text: "Название:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonText: "Add",
                cancelButtonText:"Cancel",

                inputPlaceholder: ""
            },
            function(inputValue){
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("Title can not be blank");
                    return false   
                }

                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url:"/tag/add-tag.html",
                    data: {
                        name:inputValue,
                        _csrf : csrfToken

                    },
                    success: function(json){
                        if(json.error){
                            swal("Error", "%(", "error");
                        }
                        else{
                            $('table tr:eq(0)').after('<tr id="item_10">\
                                <td>'+json.tag_name+'</td>\
                                <td>\
                                    <a href="/tag/edit/'+json.tag_id+'.html">Изменить</a> |\
                                    <a href="#" class="dell-item" data-dell-url="/tag/dell.html" data-item-id="'+json.tag_id+'" data-item-name="ffff">Удалить</a>\
                                </td>\
                            </tr>'
                            );
                            swal("Added!", "Tag added!", "success");
                        }
                    },
                    dataType: 'json'
                });
            });

        return false;
    });
});
