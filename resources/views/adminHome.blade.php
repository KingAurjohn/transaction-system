<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css_folder/admin_home.css')}}">
</head>
<body>
    <div class="main-container">
        <div class="main-header">
            <img src="{{asset('/images/Caraga_State_University_-_Cabadbaran_Campus_logo_(Reduced).png')}}" class="logo">
            <label>CSUCC Transaction</label>
            <ul class="header-menu">
                <li><button onclick="goto_home()">HOME</button></li>
                <li><button onclick="pull_out()">PULL OUT LIST</button></li>
                <li><button onclick="goto_add()">ADD</button></li>
                <li><button onclick="logout()">LOG OUT</button></li>
            </ul>
        </div>
        <p style="color: red" id="sign"></p>
                @if(session()->has('success'))
                    <p style="color: red">{{ session('success') }}</p>
                @endif
                @if(session()->has('error'))
                    <p style="color: red">{{ session('error') }}</p>
                @endif
        <div class="main-content" id = "main-content">
            <div id="table-content">
            </div>
            
        </div>
    </div>
</body>
<script>
    
    fetch("{{route('fetch_transactions')}}")
    .then(response=>{
        if(!response.ok){
            throw new Error("There is something wrong");
        }
        return response.json();
    })
    .then(data=>{
        if(data){
            let row = ``;
            let main_row = ``;

            data.forEach(row=>{
                row =  `
                    <tr>
                        <td>${row['id']}</td>
                        <td>${row['FUND_cluster']}</td>
                        <td>${row['BUR_number']}</td>
                        <td>${row['PO_number']}</td>
                        <td>${row['Supplier']}</td>
                        <td>${row['Description']}</td>
                        <td>${row['Amount']}</td>
                        <td>${row['Target_Delivery']}</td>
                        <td>${row['Office']}</td>
                        <td><button onclick="goto_pullout(${row['id']})" value="${row['id']}">PULL OUT</button><button onclick="goto_delete1(${row['id']})" value="${row['id']}">DELETE</button></td>
                    </tr>
                `;
                main_row = row + main_row;
            })
            document.getElementById('main-content').innerHTML = `
            
            <div id="table-content">
                <h3 style="color: green">HOME</h3>
                <table>
                    <tr>
                        <th>id</th>
                        <th>Fund Cluster</th>
                        <th>BUR Number</th>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Target Delivery</th>
                        <th>Office</th>
                        <th></th>
                    </tr>
                    ${main_row}
                </table>
            <div id="table-content">

            `;
        }
    })
    .catch(error=>{
        console.log(error);
    })


    function goto_add(){
        $content = `
        <form action="{{route('add_transaction')}}" method="GET">
                <label>Supply Information: </label>
                <label></label>
                <input type="text" name="fund_cluster" placeholder="Enter FUND CLUSTER" required>
                <input type="text" name="bur_number" placeholder="Enter BUR Number">
                <input type="text" name="suppliername" placeholder="Enter Supplier Name" required>
                <input type="text" name="description" placeholder="Enter Description" required>
                <input type="text" name="amount" placeholder="Enter Amount" required><br>
                <label>Target Delivery: </label>
                <label></label>
                <input type="date" name="target_delivery" placeholder="Enter Target Delivery" required>
                <select name="office" required>
                    <option>SELECT OFFICE</option><br>
                    <option value= "OSAS">OSAS</option><br>
                    <option value= "QUAMS">QUAMS</option><br>
                    <option value= "HRMO">HRMO</option><br>
                    <option value= "CSG">CSG</option><br>
                    <option value= "CITTE">CITTE</option><br>
                    <option value= "ADMIN GSO">ADMIN GSO</option><br>
                </select>
                <input type="submit" value="Submit" class="submit-btn">
            </form>
        `;
        document.getElementById('main-content').innerHTML = $content;
    }

    function goto_display(){

    }

    function goto_pullout(id){
        if(window.confirm("DO YOU WANT PULL THIS OUT?")){
            console.log('you do');
        }else{
            return;
        }
        data = {
            id: id
        }
        fetch("{{route('pullout')}}",{
            method: "POST",
            headers: {
                'Content-type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response=>{
            if(!response.ok){
                throw new Error("Error");
            }
            return response.json();
        })
        .then(data=>{
            if(data){
                if(data['status'] == 'successful'){
                    document.getElementById('sign').innerHTML = 'Pulled OUT successful';
                    window.location.href="{{route('enter_admin')}}";
                }else{
                    document.getElementById('sign').innerHTML = 'Pulled OUT failed';
                }
            }
        })
        .catch(error=>{
            console.log(error);
        })
    }

    function pull_out(){
        fetch("{{route('fetch_pulledOut')}}")
        .then(response=>{
            if(!response.ok){
                throw new Error("There is something wrong");
            }
            return response.json();
        })
        .then(data=>{
            if(data){
                let row = ``;
                let main_row = ``;

                data.forEach(row=>{
                    row =  `
                        <tr>
                            <td>${row['FUND_cluster']}</td>
                            <td>${row['BUR_number']}</td>
                            <td>${row['PO_number']}</td>
                            <td>${row['Supplier']}</td>
                            <td>${row['Description']}</td>
                            <td>${row['Amount']}</td>
                            <td>${row['Target_Delivery']}</td>
                            <td>${row['Office']}</td>
                            <td><button onclick="goto_delete2(${row['id']})" value="${row['id']}">DELETE</button></td>
                        </tr>
                    `;
                    main_row = row + main_row;
                })
                document.getElementById('main-content').innerHTML = `
                    <div id="table-content">
                        <h3 style="color: green">PULLED OUT LIST</h3>
                        <table>
                            <tr>
                                <th>Fund Cluster</th>
                                <th>BUR Number</th>
                                <th>PO Number</th>
                                <th>Supplier</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Target Delivery</th>
                                <th>Office</th>
                                <th></th>
                            </tr>
                            ${main_row}
                        </table>
                    <div id="table-content">

                `;
            }
        })
        .catch(error=>{
            console.log(error);
        })
    }

    function goto_home(){
        window.location.href = "{{route('enter_admin')}}";
    }

    function goto_delete1(id){
        data = {
            id: id
        }
        fetch("{{route('delete1')}}",{
            method: "POST",
            headers: {
                'Content-type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response=>{
            if(!response.ok){
                throw new Error("Error");
            }
            return response.json();
        })
        .then(data=>{
            if(data){
                if(data['status'] == 'successful'){
                    document.getElementById('sign').innerHTML = 'DELETED successful';
                    window.location.href="{{route('enter_admin')}}";
                }else{
                    document.getElementById('sign').innerHTML = 'DELETED failed';
                }
            }
        })
        .catch(error=>{
            console.log(error);
        })
    }

    function goto_delete2(id){
        data = {
            id: id
        }
        fetch("{{route('delete2')}}",{
            method: "POST",
            headers: {
                'Content-type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response=>{
            if(!response.ok){
                throw new Error("Error");
            }
            return response.json();
        })
        .then(data=>{
            if(data){
                if(data['status'] == 'successful'){
                    document.getElementById('sign').innerHTML = 'DELETED successful';
                    window.location.href="{{route('enter_admin')}}";
                }else{
                    document.getElementById('sign').innerHTML = 'DELETED failed';
                }
            }
        })
        .catch(error=>{
            console.log(error);
        })
    }

    function logout(){
        window.location.href="{{route('home')}}";
    }
</script>
</html>
