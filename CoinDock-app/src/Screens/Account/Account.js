import React  from 'react';
import Accordion from './Accordian';
import "./Account.css";
import {useAccount} from "App/Api/accapi";
import { useNavigate } from "react-router-dom";
import "Shared/common-styles/button.css";
import { useLogout } from "App/Api/auth";
import "Shared/common-styles/common.css";

function Account() {
 const { data: account}= useAccount();
 
 const accountDetails = account?.result?.user || {};
 const [logout] = useLogout();
 const navigate = useNavigate();

 const accordianBasedAccountDetails = [
   {
     label:'Profile Settings',
     field:[
       {
       label:'Name',
       fieldKey:'name',
       type:'edit'
      },
       {
        label:'DateofBirth',
        fieldKey:'dateofbirth',
        type:'edit'
       },
       {
        label:'Country',
        fieldKey:'country',
        type:'edit'
       },
    ]
   },
   {
     label:'Account Settings',
     field:[
         {
          label:'Email',
          fieldKey:'email',
          type:'edit'
         },
         {
          label:'Change Password',
          fieldKey:'changePassword',
          type:'edit'
         },
         {
          label:'Recovery Code',
          fieldKey:'recoverycode',
          navigate:true,
         },
       
    ]
   },
     {
     label:'System Settings',
     field:[
       {
         label:'Primary currency',
         fieldKey:'primarycurrency',
       },
       {
        label:'Secondry currency',
        fieldKey:'secondrycurrency',
      }
     ]
     }
  ]

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
         {accordianBasedAccountDetails && accordianBasedAccountDetails.map((item,id) => (
               <div>
                  <Accordion key={id} label={item.label} field={item.field} value={accountDetails} />
                </div>
          ))}
       </div><div className='d-flex justify-content-start'>
           <button className='cd-button cd-button-2 cd-logout-button' onClick={handleLogoutClick}>Logout</button>
         </div>
     </div>

    );
};
export default Account;
