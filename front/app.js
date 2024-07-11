var allUsers = [];
async function getAllUsers () {
    const res = await fetch('http://localhost/sites/internetlab/users');
    const users = await res.json();
    let str = '' +
        '<tr>' +
        '<th>ID</th>' +
        '<th>Name</th>' +
        '<th>Email</th>' +
        '<th></th>' +
        '<th></th>' +
        '</tr>';
    await users.forEach((user) => {
            str += '' +
                '<tr>' +
                    '<td>'+ user.id +'</td>' +
                    '<td>'+ user.name +'</td>' +
                    '<td>'+ user.email +'</td>' +
                    '<td><a href="#" onclick="makeUpdateForm('+ user.id +')">Изменить</a></td>' +
                    '<td><a href="#" onclick="deleteUser('+ user.id +')">Удалить</a></td>' +
                '</tr>';
            allUsers = [...allUsers, user];
        }
    )
    document.getElementById('table').innerHTML = str;
}

async function createNewUser () {
    let formData = new FormData();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    let hasThisEmail = false;
    allUsers.forEach((user) => {
        if (email === user.email) {
            return hasThisEmail = true;
        }
    })
    if(hasThisEmail) return document.getElementById('emailMessage').innerText = 'Пользователь с таким E-Mail уже существует';

    formData.append('name', name);
    formData.append('email', email);
    formData.append('password', password);
    const res = await fetch('http://localhost/sites/internetlab/users', {
        method: 'POST',
        body: formData
    });
    const data = await res.json();
    if (data.status) {
        getAllUsers();
        document.getElementById('form').innerHTML = ' <label>\n' +
            '        Name <br>\n' +
            '        <input id="name">\n' +
            '        <span id="nameMessage"></span>\n' +
            '    </label>\n' +
            '    <br>\n' +
            '    <label>\n' +
            '        Email <br>\n' +
            '        <input id="email">\n' +
            '        <span id="emailMessage"></span>\n' +
            '    </label>\n' +
            '    <br>\n' +
            '    <label>\n' +
            '        Password <br>\n' +
            '        <input id="password">\n' +
            '        <span id="passwordMessage"></span>\n' +
            '    </label>\n' +
            '    <button onclick="createNewUser()">Создать</button>'
    } else {
        if (res.status == 500) {
            alert(data.message)
        } else {
            if (data.message.name) document.getElementById('nameMessage').innerText = data.message.name;
            if (data.message.email) document.getElementById('emailMessage').innerText = data.message.email;
            if (data.message.password) document.getElementById('passwordMessage').innerText = data.message.password;
        }
    }
}

function makeUpdateForm (id) {
    let updateUser = 'none';
    allUsers.forEach((user) => {
        if (user.id === id) {
            return updateUser = user;
        }
    })
    if (updateUser === 'none') return alert('Пользователь не найден')
    document.getElementById('formUpdate').style.display = '';
    document.getElementById('nameUpdate').value = updateUser.name;
    document.getElementById('emailUpdate').value = updateUser.email;
    document.getElementById('updateUserId').value = updateUser.id;
}

async function updateUser () {
    const id = document.getElementById('updateUserId').value;
    const name = document.getElementById('nameUpdate').value;
    const email = document.getElementById('emailUpdate').value;
    const password = document.getElementById('passwordUpdate').value;

    document.getElementById('nameMessageUpdate').innerText = '';
    document.getElementById('emailMessageUpdate').innerText = '';
    document.getElementById('passwordMessageUpdate').innerText = '';

    let body = {
        name: name,
        email: email,
        password: password,
    }

    const res = await fetch(`http://localhost/sites/internetlab/users/${id}`, {
        method: 'PATCH',
        body: JSON.stringify(body)
    });

    const data = await res.json();
    if (data.status) {
        getAllUsers();
        document.getElementById('formUpdate').style.display = 'none';
    } else {
        if (res.status == 500) {
            alert(data.message)
        } else {
            if (data.message.name) document.getElementById('nameMessageUpdate').innerText = data.message.name;
            if (data.message.email) document.getElementById('emailMessageUpdate').innerText = data.message.email;
            if (data.message.password) document.getElementById('passwordMessageUpdate').innerText = data.message.password;
        }
    }

}

async function deleteUser(id) {
    const res = await fetch(`http://localhost/sites/internetlab/users/${id}`, {
        method: 'DELETE',
    });
    const data = await res.json();
    if (data.status) {
        getAllUsers();
    } else {
        alert(data.message);
    }
}

getAllUsers()