import React, { useEffect, useState } from "react";
import Popup from "Shared/Popup/Popup";
import { RiCloseLine } from "react-icons/ri";
import { useCurrency } from "App/Api/accapi";
import { useCountry } from "App/Api/accapi";
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
import { countryValidation } from 'Shared/Form/Select/Select';
import DatePick ,{ dateValidation } from 'Shared/Date/DatePick';
import "Shared/common-styles/space.css";
import "Shared/common-styles/common.css";
const EditPopup =() =>{
  const {open,type,value} = useSelector(state => state.account)
  const initialValues = {
    firstname: value.first_name,
    lastname: value.last_name,
    date: value.date_of_birth,
    email: value.email,
    country: value.country,
    coin:value.coin_name,
    password: "",
    primary_currency:value.primary_currency,
    secondary_currency:value.secondary_currency,
  };

const {data: currencyfilter} = useCurrency();
const {data: countryfilter} = useCountry();
const [formValues, setformValues] = useState(initialValues);
const [formErrors, setformErrors] = useState({});
const [isValid, setValid] = useState(false);
const dispatch = useDispatch();
const [getData ]= useData();
const [filter,setFilter] =useState({})
const handleChanges = (e) => {
  const { name, value } = e.target;
  setformValues({ ...formValues, [name]: value });
  handleValidation({ ...formValues, [name]: value });
};
const resetInputField = () => {
  setformValues(initialValues);
};
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

const handleSubmit = () => {
  const { errors, isValid } = handleValidation(formValues);
    if (!isValid) {
      setformErrors(errors);
    } else {
      getData({
        ...formValues,
      })
        .catch((e) => {
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
  const handleChange = (e) => {
     setFilter(e.target.value);
     };
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
       formErrors={formErrors}
    />:
    type == 'country' ?
    <select
      className="form-control cd-select cd-mt-8"
      name="country"
      onChange={handleChange}
      defaultValue={formValues.country}
      label="Country">
     {countryfilter?.results?.countries?.map((value) => {
       return (
         <option
           value={value}
           key={value}
          >
          {value}
         </option>)
     })}
     </select>:
      type == 'primarycurrency' ?
      <select
          className="form-control cd-select cd-mt-8"
          name="primarycurrency"
          onChange={handleChange}
          defaultValue={formValues.primary_currency}
          label="Primary Currency">
           {currencyfilter?.results?.coins?.map((value,id) => {
             return (
               <option
                 value={value.coin_id}
                 key={id}
                >
                {value.coin_id}
               </option>)
           })}
       </select>:
        type == 'secondarycurrency' ?
        <select
          className="form-control cd-select cd-mt-8"
          name="secondarycurrency"
          onChange={handleChange}
          defaultValue={formValues.secondary_currency}
          label="Secondary Currency">
             {currencyfilter?.results?.coins?.map((value,id) => {
             return (
               <option
                 value={value.coin_id}
                 key={id}
                >
                {value.coin_id}
               </option>)
           })}
         </select>:
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
    </div> : null

  }
   </Popup>
 </form>
 </div>
)}
export default EditPopup;
