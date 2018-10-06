#include <cstdio>

int main()
{
    scanf("%lld",&n);
    int r=1;
    for (int i=1;i<=n;i++) r=r*i;
    printf("%lld",r);
}