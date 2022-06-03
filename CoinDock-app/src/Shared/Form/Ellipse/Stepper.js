import React from "react";
import "./Stepper.css";
import "../../common-styles/space.css";

function Stepper({ totalSteps, currentActiveSteps }) {
  return (
    <div className="stepper cd-mp-14 cd-mb-27 cd-mt-19">
      {[...new Array(totalSteps)].map((value, index) => {
        return (
          <React.Fragment key={index}>
            {Boolean(index) && (
              <div
                className="line"
                style={{ width: `calc((100%-32px)/${totalSteps - 1})` }}
              />
            )}
            <div className="stepper-step" />
          </React.Fragment>
        );
      })}
    </div>
  );
}
export default Stepper;
