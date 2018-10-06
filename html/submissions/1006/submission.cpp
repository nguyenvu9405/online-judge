#include<cstdio>
int main()
{
    long long n;
    int ans=0;
    scanf("%lld", &n);
    while (n)
    {
        if (n%10%2) ans+=n%10;
        n/=10;
    }
    printf("%d", ans);
    return 0;
}
