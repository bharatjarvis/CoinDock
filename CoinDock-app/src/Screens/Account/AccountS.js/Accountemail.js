import React,{useState} from "react";
import { useAccount } from "App/Api/accapi";
import Email from "Shared/Form/Email/Email";
import { useAccountData } from 'App/Api/accapi';
import { emailValidation } from 'Shared/Form/Email/Email';
function Accountemail () {
  const { data: account}= useAccount();
  const accountDetails =account?.data?.results?.user || {};
  const [formErrors, setformErrors] = useState({});
  const initialValues = {
    email: accountDetails.email,
    };
    const [formValues, setformValues] = useState(initialValues);
    const [isValid, setValid] = useState(false);
    const [getData ]= useAccountData();
    const handleChanges = (e) => {
      const { name, value } = e.target;
      setformValues({ ...formValues, [name]: value });
      handleValidation({ ...formValues, [name]: value });
    };
    const handleValidation =(values) =>{
      const errors = {};
      errors.email = emailValidation(values.email)
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
          .catch();
      }
    };

  return(
      <div className="container-2 col py-5">
          <h3>Edit Email</h3>
      <form  onInput ={handleChanges}>
      <Email
      name="email"
      formErrors={formErrors}
      value={formValues.email}
      />
        </form>
        <div className="cd-edit-style">
        <button
          className="cd-button-2 cd-button "
          disabled={!isValid}
          onClick={handleSubmit}
          >
          Submit
         </button>
      </div>
      </div>
  )
}
export default Accountemail
