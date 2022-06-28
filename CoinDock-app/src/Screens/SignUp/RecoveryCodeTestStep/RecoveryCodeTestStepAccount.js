import React, { useState } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import RecoveryBoxs from "Shared/Form/RecoveryBoxes";
import "Shared/common-styles/common.css";
import "Shared/common-styles/button.css";
import {
  usePutRecoveryCodesMutation,
  useGetRandomRecoveryCodesQuery,
} from "App/Api/recoveryCodes";
import { useNavigate } from "react-router-dom";
import "./RecoveryCodeTest.css";
import Popup from "Shared/Popup/Popup";

function RecoveryCodeTestStep() {
  const navigate = useNavigate();

  const { data = [] } = useGetRandomRecoveryCodesQuery();

  const [recoveryTestCodes, { error }] = usePutRecoveryCodesMutation();

  const [formValues, setformValues] = useState({
    key_response: {},
  });

  const [buttonPopup, setButtonPopup] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await recoveryTestCodes({ userId: 1, ...formValues }).unwrap();

      navigate("/logout");
    } catch (error) {
      if (error.status === 400) {
        setButtonPopup(true);
      }
    }
  };

  const handleOnInput = (event) => {
    setformValues((formValues) => {
      formValues.key_response[event.target.name] = event.target.value;
      return formValues;
    });
  };

  const recoveryCodes = data?.results;

  return (
    <div className="paper">
      <div className="paper-container">
        <div className="row content d-flex justify-content-center align-items-center">
          <div style={{ height: "100%" }}>
            <div>
              <div className="d-flex justify-content-between"></div>
              <form onInput={handleOnInput}>
                <div className="p-3" />

                <div className="cd-step-header-content">
                  Please enter the recovery words on the same order to activate
                  the CoinDock account.
                </div>

                <div className="p-3" />

                <div className="cd-recover-test-table">
                  {Boolean(recoveryCodes) &&
                    [...Array(recoveryCodes.length).keys()].map(
                      (number, index) => {
                        return (
                          <RecoveryBoxs
                            key={index}
                            index={recoveryCodes[number]}
                            submitEvent={true}
                            input={true}
                          />
                        );
                      }
                    )}
                </div>
                <div className="p-3" />
                <div className="row cd-row-space-between">
                  <div className="col-md-4 cd-width-unset">
                    <button
                      className="cd-button"
                      onClick={() => {
                        navigate("/recovery-codes-account");
                      }}
                    >
                      Back
                    </button>
                  </div>

                  <div className="col-md-4 offset-md-4 cd-width-unset">
                    <button className="cd-button" onClick={handleSubmit}>
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
