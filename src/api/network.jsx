const url = "https://world.openfoodfacts.org/api/v2/";

const networkGet = async (route) => {
  const response = await fetch(url + route);
  return await response.json();
};

const networkGetProduct = async (input) => {
  // https://world.openfoodfacts.org/api/v2/search?categories_tags=${this.userInput}
  const prodUrl = `${url}search?categories_tags=${input}`;
  const response = await fetch(prodUrl);
  const result = await response.json();
  if (result.count == 0) {
    const brandUrl = `${url}search?brands_tags=${input}`;
    const secondResponse = await fetch(brandUrl);
    return await secondResponse.json();
  } else {
    return result;
  }
};

export { networkGet, networkGetProduct };
