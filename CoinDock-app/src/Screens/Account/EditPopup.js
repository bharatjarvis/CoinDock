import React, { useEffect, useState } from 'react';
import Popup from 'Shared/Popup/Popup';
import { RiCloseLine } from "react-icons/ri";
import Email from 'Shared/Form/Email';
import Password from 'Shared/Password/Password';
import RecoveryBoxes from 'Shared/Form/RecoveryBoxes';
import { useSelector } from 'react-redux';
import {closeDialogue} from 'App/Auth/reducers/accReducer';
import { useDispatch } from 'react-redux';
import { useData } from 'App/Api/accapi';
import { useNavigate } from 'react-router-dom';
import { passwordValidation } from 'Shared/Password/Password';
import { emailValidation } from 'Shared/Form/Email/Email';

const EditPopup =() =>{
const {open, type} = useSelector(state => state.account)
const dispatch = useDispatch();
const [formValues, setformValues] = useState(null);
const [getData ]= useData();
let navigate = useNavigate();
const [formErrors, setformErrors] = useState({});
const [isValid, setValid] = useState(false);
const [displayErrorMessage, setDisplayErrorMessage] = useState(false);

const handleValidation =(values) =>{
  const errors = {};
  if(type == 'email'){
    errors.email = emailValidation(values.email)
  }
  if(type == 'changePassword'){
   errors.password = passwordValidation({
    value: values.password,
    label: "Password",
    minlength: 12,
    maxlength: 45,
  }) }
  const isValid = !Object.values(errors).some(Boolean)
  console.log(errors,values,type);
  setValid(isValid);
  return {
    isValid,
    errors,
  };
}
const handleChanges = (e) => {
  const { name, value } = e.target;
  setformValues({ ...formValues, [name]: value });
};
const resetInputField = () => {
  setformValues(null);
};

const handleSubmit = () => {
  const { errors, isValid } = handleValidation(formValues);
    if (!isValid) {
      setformErrors(errors);
    } else {
      getData({
        ...formValues,
      }) 
        .unwrap()
        .then(() => {
          navigate("/dashboard");
        })
        .catch(() => {
          setDisplayErrorMessage(true);
        });
    }
    console.log(formValues);
    
};
const handleSetTrigger = () => {
dispatch(closeDialogue());
};

useEffect (()=>{
  if(!open){
    resetInputField()
  }
},[open])
return(
<div>
<form  onInput ={handleChanges} >
  <Popup
    trigger={open}
    setTrigger={handleSetTrigger}
    buttonLable="Done"
    buttonOnclick={handleSubmit}
  >
    <div className="d-flex justify-content-between">
      <h4>Account settings</h4>
      <RiCloseLine
        size="30px"
        cursor="pointer"
        onClick={() => handleSetTrigger(false)}
      />
    </div>
    { type === 'email' ? 
    <Email
      name="email"
      />:
     type === 'changePassword' ? 
    <Password 
      name="password"
      placeholder="Enter your password"
      label="Password"
    /> :
     type === 'regenerateRecoveryWords' ? 
    <RecoveryBoxes
      label="RecoveryWords"
    /> :''}
 
  </Popup>
 </form>
 </div>

)}
export default EditPopup;