import React, { useState } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import RecoveryBoxs from "Shared/Form/RecoveryBoxes";
import "Shared/common-styles/common.css";
import "Shared/common-styles/button.css";
import Stepper from "Shared/Form/Ellipse/Stepper";
import {
  usePutRecoveryCodesMutation,
  useGetRandomRecoveryCodesQuery,
} from "App/Api/recoveryCodes";
import { useNavigate } from "react-router-dom";
import "./RecoveryCodeTest.css";
import Popup from "Shared/Popup/Popup";

function RecoveryCodeTestStep() {
  const [buttonPopup, setButtonPopup] = useState(false);

  const [isEnterted, setIsEnterted] = useState(false);

  const [displayErrorMessage, setDisplayErrorMessage] = useState(false);

  const navigate = useNavigate();

  const { data = [] } = useGetRandomRecoveryCodesQuery(
    {},
    { refetchOnMountOrArgChange: true }
  );

  const [recoveryTestCodes, { error }] = usePutRecoveryCodesMutation();

  const [formValues, setformValues] = useState({
    key_response: {},
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    await recoveryTestCodes({
      ...formValues,
    })
      .unwrap()
      .then(() => {
        navigate("/dashboard");
      })
      .catch((error) => {
        if (error.status === 400) {
          setButtonPopup(true);
        }
        if (error.status === 422) {
          setDisplayErrorMessage(true);
        }
      });
  };

  const handleOnInput = (event) => {
    setIsEnterted(true);
    setformValues((formValues) => {
      formValues.key_response[event.target.name] = event.target.value;
      return formValues;
    });
  };

  const handleOnFocus = () => {
    if (displayErrorMessage) setDisplayErrorMessage(false);
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
              {displayErrorMessage && (
                <p className="cd-error">
                  {error?.data?.message.substring(
                    0,
                    error?.data?.message.indexOf(".")
                  ) + "."}
                </p>
              )}
              <form onInput={handleOnInput} onFocus={handleOnFocus}>
                <div className="p-3" />

                <div className="cd-step-header-content">
                  Please enter the recovery words on the same order to activate
                  the CoinDock account.
                </div>

                <div className="p-3" />

                <div className="cd-recover-table">
                  {Boolean(recoveryCodes) &&
                    recoveryCodes.map((number, index) => {
                      return (
                        <RecoveryBoxs
                          key={index}
                          index={number}
                          submitEvent={true}
                          input={true}
                        />
                      );
                    })}
                </div>
                <div className="p-3" />
                <div className="row cd-row-space-between">
                  <div className="col-md-4 cd-width-unset">
                    <button
                      className="cd-button"
                      onClick={() => {
                        navigate("/recovery-codes");
                      }}
                    >
                      Back
                    </button>
                  </div>

                  <div className="col-md-4 offset-md-4 cd-width-unset">
                    <button
                      className="cd-button cd-button-2"
                      disabled={!isEnterted}
                      onClick={handleSubmit}
                    >
                      Confirm
                    </button>
                  </div>
                </div>
              </form>
              <Popup
                trigger={buttonPopup}
                setTrigger={setButtonPopup}
                buttonLable="OK"
              >
                <p>{error?.data?.error?.message}</p>
              </Popup>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default RecoveryCodeTestStep;
