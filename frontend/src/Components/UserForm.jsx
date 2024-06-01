import React, {useState, useEffect} from "react";
import axios from "axios";

const UserForm = ({userToEdit, onSave}) => {
    const [user, setUser] = useState({name: '', lastname: '', email: ''});

    useEffect(() => {
        if (userToEdit) {
            setUser(userToEdit);
        }
    }, [userToEdit]);

    const handleChange = (e) => {
        const {name, value} = e.target;
        setUser({...user, [name]: value});
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (user.id) {
            axios.put(`http://localhost/practicaphp/Backend/${user.id}`, user)
            .then(response => onSave(response.data))
            .catch(error => console.error('Error al actualizar usuario:',error));
        } else {
            axios.post('http://localhost/practicaphp/Backend/', user)
            .then(response => onSave(response.data))
            .catch(error => console.error('Error al crear Usuario:', error));
        }
        setUser({name: '', lastname: '', email: ''});
    };

    return(
        <div className="container mt-5">
            <form onSubmit={handleSubmit}>
                <h2>{user.id ? 'Editar Usuario' : 'Añadir Usuario'}</h2>
                <div className="form-group mb-3">
                    <label>Nombre</label>
                    <input type="text" name="name" value={user.name} onChange={handleChange} className="form-control" placeholder="Nombre" required />
                </div>
                <div className="form-group mb-3">
                    <label>Apellidos</label>
                    <input type="text" name="lastname" value={user.lastname} onChange={handleChange} className="form-control" placeholder="Apellidos" required />
                </div>
                <div className="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value={user.email} onChange={handleChange} className="form-control" placeholder="Email" required />
                </div>
                <button type="submit" className="btn btn-primary">{user.id ? 'Actualizado' : 'Añadir'}</button>
            </form>
        </div>
    );
};
export default UserForm;