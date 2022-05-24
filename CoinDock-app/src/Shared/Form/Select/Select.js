import React from 'react';

const Select = ({options,label, ...props}) => {
    return <>
    <label>{label}</label>
    <select>
        {options.map(({value, label}, index) => {
            return <option value={value} key={index}>
                {label}
            </option>
        })}
    </select>
    </>
}

export default Select;
