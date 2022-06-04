import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import RecoveryBoxs from "../../../Shared/Form/RecoveryBoxes";
import "../../../Shared/common-styles/common.css";
import "../../../Shared/common-styles/button.css";
import Stepper from "../../../Shared/Form/Ellipse/Stepper";
import {
  usePutRecoveryCodesMutation,
  useGetRandomRecoveryCodesQuery,
} from "../../../App/Api/recoveryCodes";
import { useNavigate } from "react-router-dom";

function RecoveryCodeTestStep() {
  const navigate = useNavigate();

  const { data = [], ...a } = useGetRandomRecoveryCodesQuery();

  // const [recoveryTestCodes] = usePutRecoveryCodesMutation({ userId: 1 });

  const handleSubmit = async (e) => {
    // e.preventDefault();
    // try {
    //   await recoveryTestCodes({ ...formValues })
    //     .unwrap()
    //     .then(() => {
    //       setButtonPopup(true);
    //     });
    // } catch (errorResponse) {
    //   setformErrors({});
    // }
  };

  const handleOnInput = (e) => {
    console.log(e);
  };

  const recoveryCodes = data?.results;

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
                <div style={{ flex: "1 4 50%;", display: "flex" }}>
                  <div className="recover-test-table">
                    {Boolean(recoveryCodes) &&
                      [...Array(recoveryCodes.length).keys()].map((number) => {
                        return (
                          <RecoveryBoxs
                            {...{
                              value: recoveryCodes[number],
                              submitEvent: true,
                              code: "",
                            }}
                          />
                        );
                      })}
                  </div>
                </div>
                <div className="p-3" />
                <div className="row">
                  <div className="col-md-4">
                    <button
                      className="cd-button"
                      onClick={navigate("/recovery-codes")}
                    >
                      Back
                    </button>
                  </div>

                  <div className="col-md-4 offset-md-4">
                    <button
                      className="cd-button"
                      onClick={handleSubmit()}
                      onInput={handleOnInput()}
                    >
                      Confirm
                    </button>
                  </div>
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
