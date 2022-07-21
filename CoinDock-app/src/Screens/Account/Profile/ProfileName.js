import React , { useState } from "react";
import Name from 'Shared/Form/Name/Name';
import { useNavigate } from "react-router-dom";
import { useAccountData } from 'App/Api/accapi';
import { useAccount } from "App/Api/accapi";
import "../../../Shared/common-styles/common.css"
import { nameValidation } from 'Shared/Form/Name/Name';
function ProfileName () {
  const { data: account}= useAccount();
  const navigate = useNavigate();
  const accountDetails = account?.data?.results?.user || {};
    const initialValues = {
      first_name: accountDetails.first_name,
        last_name: accountDetails.last_name
      };
      const [isValid, setValid] = useState(false);
      const [getData ]= useAccountData();
      const handleChanges = (e) => {
        const { name, value } = e.target;
        setformValues({ ...formValues, [name]: value });
        handleValidation({ ...formValues, [name]: value });
      };
     
      const handleValidation =(values) =>{
        const errors = {};
        errors.first_name = nameValidation(values.first_name,'First Name',45) ;
        errors.last_name = nameValidation(values.last_name,'Last name',45);
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
            }).unwrap().then(() => {
              navigate('/profile-settings')
            })
          }
      };
    const [formValues, setformValues] = useState(initialValues);
    const [formErrors, setformErrors] = useState({});

    return(
        <div className="container-2 col py-5">
            <h3>Edit name</h3>
        <form  onInput ={handleChanges} >
            <Name
             name="first_name"
             placeholder="Enter First Name"
             label="First Name"
             value={formValues.first_name}
             formErrors={formErrors}
           />
          <Name
           name="last_name"
           placeholder="Enter Last Name"
           label="Last Name"
           value={formValues.last_name}
            formErrors={formErrors}
          />
          </form>
          <div className="cd-edit-style">
          <button
            className="cd-button-2"
            disabled={!isValid}
            onClick={handleSubmit}
            >
            Submit
           </button>
        </div>
        </div>
    )
}
export default ProfileName
