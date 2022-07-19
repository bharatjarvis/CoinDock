import React, { useState } from "react";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Pie } from "react-chartjs-2";
import { usePieChart } from "App/Api/piechartapi";
import { usePieFilter } from "App/Api/piechartapi";
import "./PieChart.css";
import { isError } from "lodash";
import { Card } from "react-bootstrap";
import Loading from "Shared/Loading/Loading";

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
      display: true,
    },
    title: {
      display: true,
      text: "Pie Chart",
    },
  },
};

export function PieChart() {
  const [filter, setFilter] = useState("coins");
  const { data: pie, isLoading, isError } = usePieChart(filter);
  const { data: piefilter } = usePieFilter();

  const labels = Object.keys(pie?.data?.results ?? {});
  const piedata = Object.values(pie?.data?.results ?? {});
  const data = {
    labels: labels,
    datasets: [
      {
        data: piedata,
        backgroundColor: [...Array(piedata.length)].map(() => {
          return generateRandomColor();
        }),
        borderWidth: 0,
      },
    ],
  };
  const handleChange = (e) => {
    setFilter(e.target.value);
  };
  console.log(piefilter);
  if (isLoading || isError) {
    return <Loading />;
  }
  return (
    <Card className="cd-pie-chart-card">
      <div className="cd-pie-chart">
        <select className="filter" name="coins" onChange={handleChange}>
          {piefilter?.data?.results.map((value) => {
            return (
              <option value={value} key={value}>
                {value}
              </option>
            );
          })}
        </select>
        <Pie options={options} data={data} />
      </div>
    </Card>
  );
}