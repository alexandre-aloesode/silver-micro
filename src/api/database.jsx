import { Form } from "react-router-dom";

const url = window.location.hostname === "localhost" ? "http://localhost/silver-micro/back/" : "";

function buildUrl(params) {
  let url = "";
  Object.keys(params).forEach((key, index) => {
    if (index === 0) {
      url += `${key}=${params[key]}`;
    } else {
      url += `&${key}=${params[key]}`;
    }
  });
  return url;
}

const dbLogin = async (data) => {
  const response = await fetch(url + "login", {
    method: "POST",
    body: data,
  });
  return await response.json();
};

const dbGet = async (payload) => {
  const params = new FormData();
  params.append("method", "GET");
  params.append("token", localStorage.getItem("token"));
  if (payload.params) {
    Object.keys(payload.params).forEach((key) => {
      params.append(key, payload.params[key]);
    });
  }
  const response = await fetch(url + payload.route, {
    method: "POST",
    body: params,
  });
  return await response.json();
};

const dbPost = async (route, data) => {
  data.append("method", "POST");
  data.append("token", localStorage.getItem("token"));
  const response = await fetch(url + route, {
    method: "POST",
    body: data,
  });
  return await response.json();
};

const dbPut = async (route, data) => {
  data.append("method", "PUT");
  data.append("token", localStorage.getItem("token"));
  const response = await fetch(url + route, {
    method: "POST",
    body: data,
  });
  return await response.json();
};

const dbDelete = async (route, data) => {
  data.append("method", "DELETE");
  data.append("token", localStorage.getItem("token"));
  const response = await fetch(url + route, {
    method: "POST",
    body: data,
    // headers: {
    //   token: localStorage.getItem("token"),
    // },
  });
  return await response.json();
};

export { dbLogin, dbGet, dbPost, dbPut, dbDelete };
