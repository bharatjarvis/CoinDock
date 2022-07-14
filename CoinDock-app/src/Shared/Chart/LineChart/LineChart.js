import { React, useEffect, useState } from "react";
import moment from "moment";

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
import {
  useCoinFilter,
  useLineChart,
  useLineFilter,
} from "App/Api/linechartapi";
import { sortBy, uniq } from "lodash";

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
);
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
      text: "Line Chart",
    },
  },
};

export function LineChart() {
  const [coinid, setCoinid] = useState("Coins");
  const [range, setRange] = useState("Day");
  const { data: line } = useLineChart({ coinid, range });
  const { data: filter } = useLineFilter();
  const { data: coinfilter } = useCoinFilter();

  const linedata = Object.entries(line?.results ?? {});
  const labels = sortBy(
    uniq(
      linedata?.reduce((prev, current, array) => {
        const label = Object.keys(current?.[1] ?? {}).map((value) => {
          return moment(value).format("DD MM YYYY, hh");
        });

        return [...prev, ...label];
      }, [])
    )
  );

  const allDatas =
    linedata?.map((data, index) => {
      const prices = Object.values(data?.[1])?.map((value) => {
        return value;
      });
      return {
        label: data?.[0],
        data: prices,
        backgroundColor: [...Array(line)]?.map(() => {
          return generateRandomColor();
        }),
        borderColor: [...Array(line)]?.map(() => {
          return generateRandomColor();
        }),
      };
    }) ?? [];

  // const onOptionClick = (e) => {
  //   const chart = ChartJS.getChart("chart");
  //   if (e.target.value === "Coins") {
  //     chart.update("show");
  //   } else if (e.target.value) {
  //     chart.update((ctx) => {
  //       return coinfilter?.data?.[ctx.datasetIndex].toString() ===
  //         e.target.value.toString()
  //         ? "show"
  //         : "hide";
  //     });
  //   }
  // };

  const handleChange = (e) => {
    setCoinid(e.target.value);
  };
  const handleRangeChange = (e) => {
    setRange(e.target.value);
  };

  const rangefilter = Object.values(filter?.results ?? {}).map((value) => {
    return value;
  });

  return (
    <div className="cd-line-chart">
      <div className="row">
        <div className="col cd-filter">
          <select
            className="cd-line-filter"
            name="coins"
            // onChange={onOptionClick}
            onChange={handleChange}
          >
            {coinfilter?.results?.map((value) => {
              return (
                <option value={value} key={value}>
                  {value}
                </option>
              );
            })}
          </select>
          &nbsp;
          <select
            className="cd-line-filter"
            name="range"
            onChange={handleRangeChange}
          >
            {rangefilter.map((value, index) => {
              console.log(rangefilter);
              console.log(value);
              return (
                <option value={value.key} key={value.key}>
                  {value.description}
                </option>
              );
            })}
          </select>
        </div>
      </div>
      <Line
        className="p-14"
        id="chart"
        options={options}
        data={{
          labels,

          datasets: allDatas,
        }}
      />
    </div>
  );
}
