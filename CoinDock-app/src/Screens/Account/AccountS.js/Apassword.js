import React ,{useState} from "react";
import { useAccountData } from 'App/Api/accapi';
import { useNavigate } from "react-router-dom";
import Password from 'Shared/Password/Password';
import { passwordValidation } from 'Shared/Password/Password';
function Apassword () {
  const [formErrors, setformErrors] = useState({});
  const initialValues = {
    password: '',
    };
    const navigate = useNavigate();
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
      errors.password = passwordValidation({
        value: values.password,
        label: "Password",
        minlength: 12,
        maxlength: 45,
      })
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
            navigate('/account-settings')
          })
        }
    };


  return(
      <div className="container-2 col py-5">
          <h3>Change Password </h3>
      <form  onInput ={handleChanges}>
      <Password
      name="password"
      formErrors={formErrors}
      placeholder="Enter your password"
      label="Password"
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
export default Apassword
