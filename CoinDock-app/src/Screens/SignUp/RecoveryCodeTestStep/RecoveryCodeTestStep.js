import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import RecoveryBoxs from "../../../Shared/Form/RecoveryBoxes";
import "../../../Shared/common-styles/common.css";
import Stepper from "../../../Shared/Form/Ellipse/Stepper";

function RecoveryCodeTestStep() {
  return (
    <div className="paper">
      <div className="paper-container">
        <div className="row content d-flex justify-content-center align-items-center">
          <div style={{ height: "100%" }}>
            <div>
              <div className="d-flex justify-content-between"></div>
              <Stepper totalSteps={3} />
              <form>
                <div className="p-3" />

                <div className="cd-step-header-content">
                  Please enter the recovery words on the same order to activate
                  the CoinDock account
                </div>

                <div className="p-3" />

                <RecoveryBoxs />

                <div className="p-3" />
                <button className="cd-button-1">Back</button>
                <div className="mb-l">
                  <button className="cd-button-1">Confirm</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default RecoveryCodeTestStep;
