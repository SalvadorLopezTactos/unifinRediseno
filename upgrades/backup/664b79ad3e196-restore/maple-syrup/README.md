# Maple Syrup

A design token implementation for Sugar products.

```shell
$  yarn install
$  yarn run build
```

## Structure

All the design tokens are nested under the `tokens/` directory, and are grouped by token type. For example, 
`tokens/color/` houses all the color variables used in the Sugar palette. 

## How does this repo work?

Using namespaced JSON and Amazon's [Style Dictionary](https://github.com/amzn/style-dictionary) library, we're able to 
build an easy to write and maintain platform with the ability to output to any desired format. This allows the tool to 
stay agnostic and flexible, while each product-level implementation to be specific.

### Transforms

_Note_: This section will be expanded over time. 

If you're interested in having Maple Syrup output to a new format, please add a new entry under the `platforms` property
in `config.js`.

### About

This project was pulled from Sprint Week '22. The motivation was, and is, to make atomic level details of the style 
toolchain consistent and reusable for every product at Sugar.

