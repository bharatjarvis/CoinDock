import { React, useState } from "react";
import moment from "moment";
import Loading from "Shared/Loading/Loading";
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
import { isEmpty, uniq } from "lodash";
import { Card } from "react-bootstrap";

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
      text: "Market Statistics",
    },
  },
  scales: {
    x: {
      grid: {
        display: false,
      },
    },
    y: {
      grid: {
        display: true,

        borderDash: [5, 5],
      },
    },
  },
};

export function LineChart() {
  const [coinid, setCoinid] = useState("Coins");
  const [range, setRange] = useState("0");
  const {
    data: line,
    isLoading,
    isError,
  } = useLineChart({ coin_id: coinid, range });
  const { data: filter } = useLineFilter();
  const { data: coinfilter } = useCoinFilter();

  const linedata = Object.entries(line?.data?.results ?? {});
  const rangefilter = Object.values(filter?.data?.results ?? {}).map(
    (value) => {
      return value;
    }
  );
  const labels = uniq(
    linedata?.reduce((prev, current, array) => {
      const label = Object.keys(current?.[1] ?? {}).map((value) => {
        if (
          rangefilter?.find(
            (value) => value.value.toString() === range.toString()
          )?.key === "Day"
        ) {
          return moment(value).format("DD-MM-YY, hh");
        }
        return moment(value).format("DD-MM-YY");
      });

      return [...prev, ...label];
    }, [])
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

  const handleChange = (e) => {
    setCoinid(e.target.value);
  };
  const handleRangeChange = (e) => {
    setRange(e.target.value);
  };

  if (isLoading) {
    return <Loading />;
  }
  if (isError || isEmpty(line?.data?.results)) {
    return null;
  }

  return (
    <Card className="cd-line-chart-card">
      <div className="cd-line-chart">
        <div className="row">
          <div className="col cd-filter">
            <select
              className="cd-line-filter"
              name="coins"
              onChange={handleChange}
            >
              {Object.entries(coinfilter?.data?.results ?? {})?.map(
                ([key, value]) => {
                  return (
                    <option value={key} key={value}>
                      {value}
                    </option>
                  );
                }
              )}
            </select>
            &nbsp;
            <select
              className="cd-line-filter"
              name="range"
              onChange={handleRangeChange}
            >
              {rangefilter.map((value) => {
                return (
                  <option value={value.value} key={value.key}>
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
    </Card>
  );
}
