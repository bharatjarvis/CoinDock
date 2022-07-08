import React, { useState } from "react";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Pie } from "react-chartjs-2";
import { usePieChart } from "App/Api/piechartapi";
import { usePieFilter } from "App/Api/piechartapi";
import "./PieChart.css";

ChartJS.register(ArcElement, Tooltip, Legend);

const generateRandomColor = () => {
  const letters = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f"];
  var color = "#";
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
};

export const options = {
  responsive: true,
  plugins: {
    legend: {
      display: false,
    },
    title: {
      display: true,
      text: "Pie Chart",
    },
  },
};

export function PieChart() {
  const [filter, setFilter] = useState("coins");
  const { data: pie } = usePieChart(filter);
  const { data: piefilter } = usePieFilter();

  
  const labels = Object.keys(pie?.result ?? {});
  const piedata = Object.values(pie?.result ?? {});
  const data = {
    labels: labels,
    datasets: [
      {
        data: piedata,
        backgroundColor: [...Array(piedata.length)].map(() => {
          return generateRandomColor();
        }),
        borderColor: [...Array(piedata.length)].map(() => {
          return generateRandomColor();
        }),
        borderWidth: 1,
      },
    ],
  };
  const handleChange = (e) => {
    setFilter(e.target.value);
  };

  return (
    <div className="cd-pie-chart ">
      <select name="coins" onChange={handleChange}>
        {piefilter?.data?.map((value) => {
          return (
            <option value={value} key={value}>
              {value}
            </option>
          );
        })}
      </select>
      <Pie options={options} data={data} />
    </div>
  );
}
