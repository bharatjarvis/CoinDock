import React  from 'react';
import Accordion from './Accordian';
import "./Account.css";
import {useAccount} from "App/Api/accapi";
import { useNavigate } from "react-router-dom";
import "Shared/common-styles/button.css";
import { useLogout } from "App/Api/auth";
import "Shared/common-styles/common.css"

function Account() {
  const { data : account,isLoading}= useAccount();
 const [logout] = useLogout();
 const navigate = useNavigate();

 const handleLogoutClick = async () => {
    try {
        await logout().unwrap();
        navigate("/login");
      } catch (e) {
        navigate("/login");
      }
    };
  return (
    <div className="container-1 justify-content-center align-items-center">
       <div className="col-md-4 col py-5 ">
         {isLoading ? '...LOADING' :'' }
          {account && account.map((account,id) => {
             return <Accordion key ={id} title={account.title} content={account.content}/>
          })}
       </div>

        <div className='d-flex justify-content-start'>
         <button className='cd-button cd-button-2 cd-login-button' onClick={handleLogoutClick}>Logout</button>
        </div>
     </div>

    );
};



export default Account;
