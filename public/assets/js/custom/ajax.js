$(document).ready(function () {
    // sử lý bận hiện pupopu
    let count = 0;

    function togglePopup() {
        console.log(count)
        if (count % 2 === 0) {
            $('.custom-popup').css({
                zIndex: "9999",
                background: "rgba(0,0,0,0.03)",
            })
            $('.card-form').css({
                transform: "translateY(0%)",
                transition: "0.5s",
            })
        } else {
            $('.custom-popup').css({
                zIndex: "-1",
                background: "rgba(0,0,0,0.0)",
            })
            $('.card-form').css({
                transform: "translateY(-200%)",
                transition: "0s",
            })
            $('#btnSubmit').text('Add');
            $('input[name=name],input[name=price],select[name=status],textarea[name=description]').val('')
        }
        count++;
    }

    $('#add-product,#btn-cancel').click(togglePopup);


    // sử lý validat form
    let nameProduct = $('input[name=name]');
    let priceProduct = $('input[name=price]');
    let statusProduct = $('select[name=status]');
    let desc = $('textarea[name=description]');
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    function validateForm() {
        let error = true;
        let erroText = $('.error');

        if (nameProduct.val() === '') {
            error = false;
            erroText.eq(0).text('Bạn chưa nhập tên');
        } else {
            erroText.eq(0).text('');
        }
        if (priceProduct.val() === '') {
            error = false;
            erroText.eq(1).text('Bạn chưa nhập giá');
        } else {
            erroText.eq(1).text('');
        }

        if (statusProduct.val() === '1' || statusProduct.val() === '2' || statusProduct.val() === '0') {
            erroText.eq(2).text('');
        } else {
            error = false;
            erroText.eq(2).text('Bạn chưa chọn trạng thái');
        }

        if (desc.val() === '') {
            error = false;
            erroText.eq(3).text('Vui lòng nhập mô tả');
        } else {
            erroText.eq(3).text('');
        }
        return error;
    }

    // hiển thị form và thêm mới sản phẩm


    $('.form-add-product').submit(function (e) {
        e.preventDefault();
        if (validateForm() && $('#btnSubmit').text() === 'Add') {
            saveData();
        }
    });

    // hiển thị fom và dữ liệu sản phẩm để cập nhật
    $(document).on('click', '.btn-update', function () {
        togglePopup();
        let id = $(this).attr('id');
        let url = 'products/update/' + id;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                nameProduct.val(response.name);
                priceProduct.val(response.price);
                statusProduct.val(response.status);
                desc.val(response.description);
                $('#btnSubmit').text('Update');
                $('.form-add-product').off('submit').submit(function (e) {
                    e.preventDefault();
                    if (validateForm() && $('#btnSubmit').text() === 'Update') {
                        saveData(id);
                    }
                });
            },
            error: function (e) {
                console.log(e)
            }
        })
    })

// thêm mới hoặc là cập nhật bản gi
    function saveData(id = null) {
        let product_url = '';
        let message = '';
        if (id != null) {
            product_url = '/products/update/' + id;
            message = 'Cập nhật thành công.';
        } else {
            product_url = '/products/add';
            message = 'Thêm mới thành công.';
        }
        console.log(product_url);
        console.log(nameProduct.val(), priceProduct.val(), statusProduct.val(), desc.val(), id);
        $.ajax({
            url: product_url,
            type: 'POST',
            data: {
                _token: csrfToken,
                id: id,
                name: nameProduct.val(),
                price: priceProduct.val(),
                status: statusProduct.val(),
                description: desc.val(),
            },
            success: function () {
                displayList();
                togglePopup();
                toastrAdd(message);
            },
            error: function (error) {
                console.log(error);
                console.log('lỗi');
            }
        });
    }

// load lại danh sách mới khi có thay đổi
    function displayList() {
        let url_list = '/products/list'
        $.ajax({
            url: url_list,
            type: "GET",
            success: function (response) {
                $('.main-table').html(response)
            },
            error: function (error) {
                console.log(error)
            }
        })
    }

// xóa bản gi
    $(document).on('click', '.btn-delete', function () {
        let id = $(this).attr('id')
        let url = '/products/delete/' + id;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        _token: csrfToken,
                        id: id,
                    },
                    success: function (response) {
                        displayList();
                    },
                    error: function (jqXHR) {
                        console.log(jqXHR);
                    }
                });
            }
        })


    })

    // sử lý chọn tất cả và ẩn hiện nút xóa tất cả
    let check = 0;
    $('#deleteAll').hide();
    $('#checkall').on('click', function () {
        $('.form-check-input').each(function () {
            if (check % 2 === 0) {
                $('#deleteAll').show();
                $(this).prop('checked', true);
                console.log($(this).prop('id') + ' = ' + $(this).is(':checked'));
                console.log('----------------------------------------------------------------');
            } else {
                $('#deleteAll').hide();
                $(this).prop('checked', false)
            }
        })
        check++;
    });

    //  sử lý ẩn hiện nút xóa tất cả khi check ô checkbox bằng tay
    $(document).on('click', '.form-check-input', function () {
        $('.form-check-input').each(function () {
            if ($(this).prop('checked') === true) {
                $('#deleteAll').show();
                return false;
            } else {
                $('#deleteAll').hide();
            }
        })
    });

    // sử lý xóa các bản gi được tích chọn

    $('.form-main-list').on('submit', function (e) {
        e.preventDefault();
        let urlDelte = 'products/delete';
        console.log($('.form-main-list').serialize());
        Swal.fire({
            title: 'Are you sure ?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                $.ajax({
                    url: urlDelte,
                    method: "POST",
                    data: {
                        _token: csrfToken,
                        arrayID: $('.form-main-list').serialize(),
                    },
                    success: function (response) {
                        console.log('done');
                        displayList();
                    },
                    error: function (jqXHR) {
                        console.log(jqXHR);
                    }
                });
            }
        })

    })
// alert thông báo

})
