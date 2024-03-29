@extends('admin.layouts.master')

@section('content')

    <!-- page start-->
    <div class="row">
        <div class="col-sm-12">
            <section class="card">
                <header class="card-header">
                    Product Table
                    <span class="tools pull-right">
                        <button type="button" id="addBtn" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#staticBackdrop">
                            <i class="fa fa-plus-circle"></i>
                            Add Product
                        </button>
                    </span>


                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Add New Product</h5>
                                    <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="productForm" method="POST" enctype="multipart/form-data">

                                        <input type="hidden" name="id" id="id">
                                        <div class="form-group">
                                            <label for="title">Product Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Product Title" required>
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('title'))?($errors->first('title')):''}}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Product Price</label>
                                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter Product Price" required>
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('price'))?($errors->first('price')):''}}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="subcategory_id">Sub Category</label>
                                            <select name="subcategory_id" id="subcategory_id" class="custom-select custom-select-sm mb-3" required>
                                                <option selected>Select Sub Category</option>
                                                @foreach($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}">{{ $subcategory->title }}</option>
                                                @endforeach
                                            </select>
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('subcategory_id'))?($errors->first('subcategory_id')):''}}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Product Description</label>
                                            <textarea name="description" id="description" class="form-control summernote" cols="30" rows="4" required></textarea>
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('description'))?($errors->first('description')):''}}</div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <label for="thumbnail">Product Thumbnail</label>
                                                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
                                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('thumbnail'))?($errors->first('thumbnail')):''}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <img id="showImage" src="{{ asset('images/noImage.png') }}" style="width: 90%;height: 100px;" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="modalClose" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" id="submitBtn" class="btn btn-primary">Add Product</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Modal end-->

                </header>
                <div class="card-body">
                    <div class="adv-table">
                        <table  class="display table table-bordered table-striped" id="data">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Thumbnail</th>
                                <th>Title</th>
                                <th>Price(Tk)</th>
                                <th >Category</th>
                                <th >Subcategory</th>
                                <th>Description</th>
                                <th >Action</th>
                            </tr>
                            </thead>
                            <tbody id="tBody">


                            </tbody>

                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection

@push('script')



    <script>

        var editData = null;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //fetch product data
        function getProduct(){
            $.ajax({
                url: "{{ route('product.get') }}",
                dataType: 'json',
                type: 'GET',
                success: function(data){
                    var product = "";
                   $.each(data,function (key,value){
                       product = product + '<tr>'
                       product = product + '<td>' + value.id + '</td>'
                       product = product + '<td>' + '<img src=" '+value.thumbnail+' " style="width: 100px; height: 70px;">' + '</td>'
                       product = product + '<td>' + value.title + '</td>'
                       product = product + '<td>' + value.price + '</td>'
                       product = product + '<td>' + value.sub_category.category.title + '</td>'
                       product = product + '<td>' + value.sub_category.title + '</td>'
                       product = product + '<td>' + value.description + '</td>'
                       product = product + '<td>'
                       product = product +  '<button title="Edit"  onclick="editProduct('+value.id+')" data-toggle="modal" data-target="#staticBackdrop" class="btn btn-primary btn-sm">' + '<i class="fa fa-pencil-square">' + '</i>' + '</button>'
                       product = product +  '<button title="Delete" onclick="deleteProduct('+value.id+')" class="btn btn-danger btn-sm ml-2">' + '<i class="fa fa-trash-o">' + '</i>' + '</button>'
                       product = product + '</td>'
                       product = product + '</tr>'
                   })
                    $('#tBody').html(product);


                },
                error: function(data){
                    console.log(data);
                }
            });

        }
        getProduct();



        //edit product
        function editProduct(id){
            $.ajax({
                url: "/product/show/" + id,
                dataType: 'json',
                type: 'GET',
                success: function(data){

                    $('#id').val(data.id);
                    $('#title').val(data.title);
                    $('#price').val(data.price);
                    $('#subcategory_id').val(data.subcategory_id);
                    $('#description').code(data.description);

                    $('.modal-title').text("Edit Product");
                    $('#submitBtn').text("Update Product");

                    editData = 1;
                },
                error: function(data){
                    console.log(data);
                }
            });
        }

        //store or update product data
        $(document).on('click','#submitBtn',function (e){
            e.preventDefault();

            var id             = $('#id').val();
            var title          = $('#title').val();
            var price          = $('#price').val();
            var subcategory_id = $('#subcategory_id').val();
            var description    = $('#description').code();
            var thumbnail      = $('#thumbnail')[0].files[0];

            var formData = new FormData();

            formData.append('title',title);
            formData.append('price',price);
            formData.append('subcategory_id',subcategory_id);
            formData.append('description',description);
            formData.append('description',description);
            formData.append('thumbnail',thumbnail);


            if (editData != null){

                //update product
                $.ajax({
                    url: "/product/update/" + id,
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data){

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Product Updated successfully.'
                        })

                        getProduct();
                        resetForm();
                        $('#modalClose').click();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

            }else {

                //add new product
                $.ajax({
                    url: "{{ route('product.store') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data){

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Product Added successfully.'
                        })

                        getProduct();
                        resetForm();
                        $('#modalClose').click();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

            }



        })


        //delete product
        function deleteProduct(id){

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/product/delete/" + id,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        type: 'GET',
                        success: function(data){
                            Swal.fire(
                                'Deleted!',
                                'Product deleted successfully.',
                                'success'
                            )

                            getProduct();

                        },
                        error: function(data){
                            console.log(data);
                        }
                    });

                }
            })


        }


        $('#addBtn').on('click',function (){
            resetForm()
        })

        //reset form
        const resetForm = () => {

            $('#id').val('');
            $('#title').val('');
            $('#price').val('');
            $('#subcategory_id').val('');
            $('#description').code('');
            $('#thumbnail').val('');
            $('.modal-title').text("Add New Product");
            $('#submitBtn').text("Add Product");

            editData = null;

        }


    </script>

@endpush
