import React, {useEffect, useState} from 'react';
import axios from 'axios';
const UserList = ({onEdit}) => {
    const [users, setUsers] = useState([]);

    useEffect(() => {
        axios.get('http://localhost/practicaphp/Backend/index.php')
        .then(response => setUsers(response.data))
        .catch(error => console.error('Error al obtener usuarios: ', error));
    }, []);

    const deleteUser = (id) => {
        axios.delete(`http://localhost/practicaphp/Backend/${id}`)
        .then(() => setUsers(users.filter(user => user.id !== id)))
        .catch(error => console.error('Error al eliminar usuario:', error));
    };

    return (
        <div className='container mt-5'>
            <h2>Lista de Usuarios</h2>
            <table className='table'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Nombres</th>
                        <th scope='col'>Apellidos</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>Editar</th>
                        <th scope='col'>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    {users.map(user => (
                        <tr key={user.id}>
                            <th>{user.id}</th>
                            <td>{user.name}</td>
                            <td>{user.lastname}</td>
                            <td>{user.email}</td>
                            <td>
                                <button className='btn btn-primary btn-sm mr-2' onClick={() => onEdit(user)}>Editar Usuario</button>
                            </td>
                            <td>
                                <button className='btn btn-danger btn-sm' onClick={() => deleteUser(user.id)}>Eliminar Usuario</button>
                            </td>
                        </tr>
                    ))}
                    
                </tbody>
            </table>
        </div>
    );
};

export default UserList;