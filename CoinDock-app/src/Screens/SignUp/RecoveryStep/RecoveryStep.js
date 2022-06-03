import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import RecoveryBoxs from "../../../Shared/Form/RecoveryBoxes";
import Checkbox from "../../../Shared/Form/CheckBox/CheckBox";
import "../../../Shared/common-styles/common.css";
import Stepper from "../../../Shared/Form/Ellipse/Stepper";
import DownloadRecoverykeys from "../../../Shared/Form/DownloadRecoverykeys";
import "../../../Shared/common-styles/button.css";
import {useGetRecoveryCodesQuery} from "../../../App/Api/recoveryCodes";


// const userId = use

// const { data: results } = useGetRecoveryCodesQuery(userId)

function RecoveryCodeBoxStep() {


  const { data = [], isFetching, isLoading,isError} =useGetRecoveryCodesQuery({userId:1})

// console.log(data)



  // }

  const handleOnClick = () => {
    // downloadble({userId: 1})

  }

  return (
    <div className="paper">
      <div className="paper-container">
        <div className="row content d-flex justify-content-center align-items-center">
          <div style={{ height: "100% " }}>
            <div>
              <div className="d-flex justify-content-between"></div>
              <Stepper totalSteps={3} />
              <form>
                <div className="p-3" />

                <div className="cd-step-header-content">
                  Please note down the below recovery words in the same order
                  and keep it securely
                </div>

                <div className="p-3" />

                <RecoveryBoxs label ={data}/>

                <div className="p-3" />

                <div class="cd-content-row-center">
                  <DownloadRecoverykeys />
                </div>

                <div className="p-3" />

                <Checkbox label = "Yes, I noted down the recovery words securely" />

                <div className="p-3" />
                <div className="cd-content-row-end">
                  <button className="cd-button" onClick={handleOnClick}>Next</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default RecoveryCodeBoxStep;
