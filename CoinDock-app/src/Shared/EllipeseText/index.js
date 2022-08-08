import React, { useCallback, useEffect, useState, useRef } from "react";

const EllipseNumber = ({
  text,
  component: Component,
  initialStrink,
  maxLetters,
  classNames,
}) => {
  const initalMount = useRef(true);
  const [isCallaped, setIsCollapesed] = useState(initialStrink);

  const [displayText, setDisplayText] = useState(text);
  useEffect(() => {}, [displayText]);
  const handleCollapse = useCallback(() => {
    setDisplayText((initialText) => {
      if (!isCallaped) return text;
      const [beforeDecimal, afterDemial] = String(text).split(".");
      return [
        beforeDecimal ?? null,
        afterDemial?.substring(0, maxLetters),
      ].join(".");
    });
    setIsCollapesed((value) => !value);
  }, [maxLetters, text, isCallaped]);
  useEffect(() => {
    if (initalMount.current) {
      if (initialStrink) {
        handleCollapse();
      }
      initalMount.current = false;
    }
  }, [initialStrink, maxLetters, text, handleCollapse]);
  return (
    <React.Fragment>
      <Component onClick={handleCollapse} classnames={classNames}>
        {displayText}
        {!isCallaped && "..."}
      </Component>
    </React.Fragment>
  );
};

EllipseNumber.defaultProps = {
  initialStrink: true,
};

export default EllipseNumber;
