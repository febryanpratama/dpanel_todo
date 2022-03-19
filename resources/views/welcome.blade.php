<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.css" integrity="sha512-y4S4cBeErz9ykN3iwUC4kmP/Ca+zd8n8FDzlVbq5Nr73gn1VBXZhpriQ7avR+8fQLpyq4izWm0b8s6q4Vedb9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>TODO List Dpanell</title>
</head>
<body>
    
    <div class="container" style="">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <span class="fs-4"><b>TODO APPS DPANELL</b></span>
          </header>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <input type="text" name="todo" class="form-control" id="todo" placeholder="Insert your TODO">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <button type="submit" id="submit" class="form-control btn btn-primary">Save</button>
                    {{-- <input type="text" class="form-control" placeholder="Insert your TODO"> --}}
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <h5 class="text-center fs-4">LIST TODO</h5>
            <hr>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>TODO</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" id="list_todo">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<div class="modal fade" id="Mymodal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				{{-- <button type="button" class="close" data-dismiss="modal">&times;</button>  --}}
				<h4 class="modal-title">Notification</h4>                                                             
			</div> 
			<div class="modal-body">
				<div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="todo_update" placeholder="update your todo">
                    </div>
                </div>
			</div>   
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>                               
				<button type="button" class="btn btn-success" data-dismiss="modal" id="update_todo">Update TODO</button>                               
			</div>
		</div>                                                                       
	</div>                                          
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js" integrity="sha512-vDRRSInpSrdiN5LfDsexCr56x9mAO3WrKn8ZpIM77alA24mAH3DYkGVSIq0mT5coyfgOlTbFyBSUG7tjqdNkNw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    $(document).ready(function(){
        getData()
    })

    function getData(){
        $('#list_todo').html('')

        $.ajax({
            'url': '{{ url("api/todo") }}',
            'type': 'get',
            success: (data)=>{
                let data_list = data.data
                $.each(data_list,function(index){
                    $('#list_todo').append(`
                    <tr>
                        <td>`+data_list[index].todo+`</td>
                        <td>`+(
                            data_list[index].is_done == 'true' ?
                            '<span class="btn btn-success">DONE</span>' : '<span class="btn btn-warning">ON GOING</span>'
                        )+`</td>
                        <td>`+
                            (data_list[index].is_done == 'true' ?
                            `
                            <span class="btn btn-warning" onClick="update(`+data_list[index].id+`)">update</span>    
                            <span class="btn btn-danger" onClick="hapus(`+data_list[index].id+`)">delete</span>                         
                            `:`
                            <span class="btn btn-success" onClick="done(`+data_list[index].id+`)">Done</span>    
                            <span class="btn btn-warning" onClick="update(`+data_list[index].id+`)">update</span>    
                            <span class="btn btn-danger" onClick="hapus(`+data_list[index].id+`)">delete</span>                             
                            `
                            )+`
                        </td>
                    </tr>
                    `)
                })
            }
        })
    }
    $('#submit').on('click', function(){

        let todo = $('#todo').val();

        if (todo == '') {
            Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'TODO Cannot NULL',
                    })
            
        }else{
            $.ajax({
                url: '{{ url("api/todo") }}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    'todo': todo,
                },
                success: (data)=>{
                    // console.log(data)
                    if (data.code == 200) {
                        Swal.fire({
                                icon: 'success',
                                title: 'Well Done',
                                text: data.data,
                            })
                            $('input[name=todo').val('')
                            getData()
                    }
                }
            })
        }

    })

    $('#close').on('click', function(){
        $('#Mymodal').modal('hide')
        $('#todo_update').val('')
    })

    function update(data){
        // console.log(data)
        $('#Mymodal').modal('show')

        $('#update_todo').on('click', function(){
            
            let updatetodo = $('#todo_update').val()
            $.ajax({
                url: '{{ url("api/updatetodo") }}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    'id': data,
                    'todo': updatetodo,
                },
                success: (data)=>{
                    // console.log(data)
                    if (data.code == 200) {
                        Swal.fire({
                                icon: 'success',
                                title: 'Well Done',
                                text: data.data,
                            })
                            $('#Mymodal').modal('hide')
                            $('#todo_update').val('')
                            getData()
                    }
                }
            })
        })

    }

    function hapus(data){
        $.ajax({
                url: '{{ url("api/deletetodo") }}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    'id': data,
                },
                success: (data)=>{
                    // console.log(data)
                    if (data.code == 200) {
                        Swal.fire({
                                icon: 'success',
                                title: 'Well Done',
                                text: data.data,
                            })
                            $('#Mymodal').modal('hide')
                            $('#todo_update').val('')
                            getData()
                    }
                }
            })
    }

    function done(data)
    {
        $.ajax({
                url: '{{ url("api/donetodo") }}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    'id': data,
                },
                success: (data)=>{
                    // console.log(data)
                    if (data.code == 200) {
                        Swal.fire({
                                icon: 'success',
                                title: 'Well Done',
                                text: data.data,
                            })
                            $('#Mymodal').modal('hide')
                            $('#todo_update').val('')
                            getData()
                    }
                }
            })
    }
</script>
</html>