import React, {useState} from 'react';
import UserList from './Components/UserList';
import UserForm from './Components/UserForm';
import './App.css';

const App = () => {
  const [userToEdit, setUsertoEdit] = useState(null);

  const handleEdit = (user) => {
    setUsertoEdit(user);
  };

  const handleSave = () => {
    setUsertoEdit(null);
  };

  return (
    <div className='container'>
      <h1 className='mt-5'>CRUD APP</h1>
      <UserList onEdit={handleEdit} />
      <UserForm userToEdit={userToEdit} onSave={handleSave} />
    </div>
  );
};
export default App;
