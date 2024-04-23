const url = window.location.hostname === "localhost" ? "http://localhost/silver-micro/back/" : "";

const dbLogin = async (data) => {
  const response = await fetch(url + "login", {
    method: "POST",
    body: data,
  });
  return await response.json();
};

const dbGet = async (route) => {
  const response = await fetch(url + route, {
    headers: {
      token: localStorage.getItem("token"),
    },
  });
  return await response.json();
};

const dbPost = async (route, data) => {
  data.append("method", "POST");
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

const dbPut = async (route, data) => {
  data.append("method", "PUT");
  const response = await fetch(url + route, {
    method: "POST",
    body: data,
    headers: {
      token: localStorage.getItem("token"),
    },
  });
  return await response.json();
};

const dbDel = async (route, data) => {
  data.append("method", "DELETE");
  const response = await fetch(url + route, {
    method: "POST",
    body: data,
    headers: {
      token: localStorage.getItem("token"),
    },
  });
};

export { dbLogin, dbGet, dbPost, dbPut, dbDel };
