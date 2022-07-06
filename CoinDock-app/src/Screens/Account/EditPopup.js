import React, { useEffect, useState } from "react";
import Popup from "Shared/Popup/Popup";
import { RiCloseLine } from "react-icons/ri";
import Email from 'Shared/Form/Email';
import Password from 'Shared/Password/Password';
import { useSelector } from 'react-redux';
import {closeDialogue} from 'App/Auth/reducers/accReducer';
import { useDispatch } from 'react-redux';
import { useData } from 'App/Api/accapi';
import { passwordValidation } from 'Shared/Password/Password';
import { emailValidation } from 'Shared/Form/Email/Email';
import Name from 'Shared/Form/Name/Name';
import { nameValidation } from 'Shared/Form/Name/Name';
import Select, { countryValidation } from 'Shared/Form/Select/Select';
import DatePick ,{ dateValidation } from 'Shared/Date/DatePick';

const EditPopup =() =>{
const {open,type,value} = useSelector(state => state.account)
const dispatch = useDispatch();
const initialValues = {
  firstname: value.first_name,
  lastname: value.last_name,
  date: value.date_of_birth,
  email: value.email,
  country: value.country,
  password: "",
};

const [formValues, setformValues] = useState(initialValues);
const [getData ]= useData();
const [formErrors, setformErrors] = useState({});
const [isValid, setValid] = useState(false);

const handleValidation =(values) =>{
  const errors = {};
  if(type == 'email'){
    errors.email = emailValidation(values.email)
  }
  if(type == 'name'){
    errors.firstname = nameValidation(values.firstname,'First Name',45) ;
    errors.lastname = nameValidation(values.lastname,'Last name',45);
  }
  if( type == 'dateofbirth'){
    errors.date = dateValidation(values.date);
  }
  if( type == 'country'){
    errors.country = countryValidation(values.country);
  }
  if(type == 'changePassword'){
   errors.password = passwordValidation({
    value: values.password,
    label: "Password",
    minlength: 12,
    maxlength: 45,
  }) }
  const isValid = !Object.values(errors).some(Boolean)
  setformErrors(errors);
  setValid(isValid);
  return {
    isValid,
    errors,
  };
}
const handleChanges = (e) => {
  const { name, value } = e.target;
  setformValues({ ...formValues, [name]: value });
  handleValidation({ ...formValues, [name]: value });
};
const resetInputField = () => {
  setformValues(initialValues);
};

  const handleSubmit = () => {
    const { errors, isValid } = handleValidation(formValues);
    if (!isValid) {
      setformErrors(errors);
    } else {
      getData({
        ...formValues,
      }) 
        .catch((e) => {
          console.log(e);
          const {
            date_of_birth,
          } = e?.data?.errors ?? {};
          setformErrors({
            date: date_of_birth,
          });
        });
    }
  
};

  const handleSetTrigger = () => {
    dispatch(closeDialogue());
  };

  useEffect(() => {
    if (!open) {
      resetInputField();
    }
  }, [open]);

return(
<div>
<form  onInput ={handleChanges} >
  <Popup
    trigger={open}
    setTrigger={handleSetTrigger}
    buttonLable="Done"
    buttonOnclick={handleSubmit}
    disabled={!isValid}
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
      formErrors={formErrors}
      value={formValues.email}
      />:
     type === 'changePassword' ? 
    <Password 
      name="password"
      formErrors={formErrors}
      placeholder="Enter your password"
      label="Password"
    /> :
    type == 'dateofbirth' ? 
    <DatePick
       name="date"
       value={formValues.date}
       onChange={handleChanges}
       formErrors={formErrors}
    />:
    type == 'country' ?
    <Select
      name="country"
      label="Country"
      value={formValues.country}
      options={[
      {label:""},
      { label: value.country },
      { label: "India", value: 1 },
      { label: "Pakistan", value: 2 },
       ]}
       formErrors={formErrors}
      />:
    type == 'name'?
    <div>
   <Name
      name="firstname"
      placeholder="Enter First Name"
      label="First Name"
      value={formValues.firstname}
      formErrors={formErrors}
      /> 
    <Name
      name="lastname"
      placeholder="Enter Last Name"
      label="Last Name"
      value={formValues.lastname}
      formErrors={formErrors}
      />
    </div>:''
                 
}
   </Popup>
 </form>
 
 </div>

)}
export default EditPopup;
