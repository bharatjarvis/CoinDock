import { React, useRef } from "react";

import "./LineChart.css";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
} from "chart.js";
import { Line } from "react-chartjs-2";

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
);

export const options = {
  responsive: true,
  plugins: {
    legend: {
      display: false,
    },
    title: {
      display: true,
      text: "Line Chart",
    },
  },
};

const labels = ["January", "February", "March", "April", "May", "June", "July"];
const label = ["Dataset1", "Dataset2"];

const allData = [
  {
    label: label[0],

    data: [35, 5, 80, 31, 26, 15, 4],
    borderColor: "rgb(255, 99, 132)",
    backgroundColor: "rgba(255, 99, 132, 0.5)",
  },
  {
    label: label[1],

    data: [65, 59, 80, 81, 56, 55, 40],
    borderColor: "rgb(53, 162, 235)",
    backgroundColor: "rgba(53, 162, 235, 0.5)",
  },
];

export function LineChart() {
  const refContainer = useRef();
  const onOptionClick = (e) => {
    refContainer.current.focus();
    const chart = ChartJS.getChart("chart");

    console.log(chart);
    if (e.target.value === "all") {
      chart.show(0, label.length);
    } else {
      chart.hide(0, label.length);
      console.log(label.length);

      // chart.show(e.target.value);
    }
  };

  return (
    <div className="container">
      <div className="cd-line-chart">
        <div className="row">
          <div className="col cd-select-coins">
            <select name="coins" ref={refContainer} onChange={onOptionClick}>
              <option value="all">Coins</option>

              <option value={0}>BTC</option>

              <option value={1}>ETH</option>
            </select>
          </div>
          <div className="col">
            <select
              name="range"
              onChange={(e) => {
                console.log(e);
              }}
            >
              <option>Range</option>

              <option value="one Week">One Week</option>
              <option value="One month">One Month</option>
              <option value="One year">One Year</option>
            </select>
          </div>
        </div>
        <Line
          id="chart"
          options={options}
          data={{
            labels,
            // datasets: index === null ? allData : [allData[index]],
            datasets: allData,
            index: 1,
          }}
        />
      </div>
    </div>
  );
}
