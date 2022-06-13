import React, { useState } from 'react';
import "./Account.css";

const Accordion = ({ title, content }) => {
  const [isActive, setIsActive] = useState(false);

  return (
    <div className="cd-accordion">
      <div className="cd-accordion-title" onClick={() => setIsActive(!isActive)}>
        <div>{title}</div>
        <div>{isActive ? '-' : '>'}</div>
      </div>
      {isActive && <div className="cd-accordion-content">{content}</div>}
    </div>
  );
};

export default Accordion;